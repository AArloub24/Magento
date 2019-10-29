<?php

namespace Blog\BlogModule\Block;

Class ViewBlog extends \Magento\Framework\View\Element\Template
{
	protected $allBlogFactory;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Blog\BlogModule\Model\AllblogFactory $allBlogFactory
	){
		parent::__construct($context);
		$this->allBlogFactory = $allBlogFactory;
	}
	
	public function getBlog()
	{
		$id = $this->getRequest()->getParam('id');
		$blog = $this->allBlogFactory->create()->load($id);
		
		return $blog;
	}
	
	protected function _prepareLayout(){
		
		parent::_prepareLayout();
		
		$blog = $this->getBlog();
		$this->pageConfig->getTitle()->set($blog->getTitle());
		
        return $this;
	}
}