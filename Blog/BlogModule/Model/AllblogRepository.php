<?php

namespace Blog\BlogModule\Model;

use Blog\BlogModule\Api\Data;
use Blog\BlogModule\Api\AllblogRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Blog\BlogModule\Model\ResourceModel\Allblog as ResourceAllblog;
use Blog\BlogModule\Model\ResourceModel\Allblog\CollectionFactory as AllblogCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class AllblogRepository implements AllblogRepositoryInterface
{
    protected $resource;

    protected $allblogFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataAllblogFactory;

    private $storeManager;

    public function __construct(
        ResourceAllblog $resource,
        AllblogFactory $allblogFactory,
        Data\AllblogInterfaceFactory $dataAllblogFactory,
        DataObjectHelper $dataObjectHelper,
		DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
		$this->allblogFactory = $allblogFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataAllblogFactory = $dataAllblogFactory;
		$this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    public function save(\Blog\BlogModule\Api\Data\AllblogInterface $blog)
    {
        if ($blog->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
            $blog->setStoreId($storeId);
        }
        try {
            $this->resource->save($blog);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the blog: %1', $exception->getMessage()),
                $exception
            );
        }
        return $blog;
    }

    public function getById($blogId)
    {
		$blog = $this->allblogFactory->create();
        $blog->load($blogId);
        if (!$blog->getId()) {
            throw new NoSuchEntityException(__('Blog with id "%1" does not exist.', $blogId));
        }
        return $blog;
    }
	
    public function delete(\Blog\BlogModule\Api\Data\AllblogInterface $blog)
    {
        try {
            $this->resource->delete($blog);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the blog: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById($blogId)
    {
        return $this->delete($this->getById($blogId));
    }
}
