<?php

namespace Blog\BlogModule\Block;

Class ListBlog extends \Magento\Framework\View\Element\Template
{
	protected $allBlogFactory;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Blog\BlogModule\Model\AllblogFactory $allBlogFactory
	){
		parent::__construct($context);
		$this->allBlogFactory = $allBlogFactory;
	}
	
	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}
	
	public function getListBlog()
	{
		$page = ($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
		$limit = ($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 2;
		
		$collection = $this->allBlogFactory->create()->getCollection();
		$collection->addFieldToFilter('status',1);
		$collection->setPageSize($limit);
		$collection->setCurPage($page);
	
		return $collection;
	}
	
	protected function _prepareLayout(){
		parent::_prepareLayout();
		$this->pageConfig->getTitle()->set(__('Latest Blogs'));
		
		if ($this->getListBlog()){
			$pager = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager', 'blog.blogmodule.pager')
									->setAvailableLimit(array(2=>2,10=>10,15=>15,20=>20))
									->setShowPerPage(true)
									->setCollection($this->getListBlog());

			$this->setChild('pager', $pager);

			$this->getListBlog()->load();
		}
        return $this;
	}
	
	public function getPagerHtml()
	{
		return $this->getChildHtml('pager');
	}
}