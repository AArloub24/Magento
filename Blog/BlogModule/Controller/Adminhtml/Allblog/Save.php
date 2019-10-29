<?php

namespace Blog\BlogModule\Controller\Adminhtml\Allblog;

use Magento\Backend\App\Action;
use Blog\BlogModule\Model\Allblog;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Rsgitech\News\Model\AllnewsFactory
     */
    private $allblogFactory;

    /**
     * @var \Rsgitech\News\Api\AllnewsRepositoryInterface
     */
    private $allblogRepository;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param \Rsgitech\News\Model\AllnewsFactory $allnewsFactory
     * @param \Rsgitech\News\Api\AllnewsRepositoryInterface $allnewsRepository
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        \Blog\BlogModule\Model\AllblogFactory $allblogFactory = null,
        \Blog\BlogModule\Api\AllblogRepositoryInterface $allblogRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->allblogFactory = $allblogFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Blog\BlogModule\Model\AllblogFactory::class);
        $this->allblogRepository = $allblogRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Blog\BlogModule\Api\AllblogRepositoryInterface::class);
        parent::__construct($context);
    }
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Blog_BlogModule::save');
	}

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Allblog::STATUS_ENABLED;
            }
            if (empty($data['blog_id'])) {
                $data['blog_id'] = null;
            }

            /** @var \Rsgitech\News\Model\Allnews $model */
            $model = $this->allblogFactory->create();

            $id = $this->getRequest()->getParam('blog_id');
            if ($id) {
                try {
                    $model = $this->allblogRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This blog no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'blog_allblog_prepare_save',
                ['allblog' => $model, 'request' => $this->getRequest()]
            );

            try {
                $this->allblogRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the blog.'));
                $this->dataPersistor->clear('blog_allblog');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['blog_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the blog.'));
            }

            $this->dataPersistor->set('blog_allblog', $data);
            return $resultRedirect->setPath('*/*/edit', ['blog_id' => $this->getRequest()->getParam('blog_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
