<?php

namespace Blog\BlogModule\Block\Adminhtml\Allblog\Edit;

use Magento\Backend\Block\Widget\Context;
use Blog\BlogModule\Api\AllblogRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;
   
    protected $allblogRepository;
    
    public function __construct(
        Context $context,
        AllblogRepositoryInterface $allblogRepository
    ) {
        $this->context = $context;
        $this->allblogRepository = $allblogRepository;
    }

    public function getBlogId()
    {
        try {
            return $this->allblogRepository->getById(
                $this->context->getRequest()->getParam('blog_id')
            )->getId();
        }
		catch (NoSuchEntityException $e) {
        
		}
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
