<?php

namespace Blog\BlogModule\Block;

Class LinkBlog extends \Magento\Framework\View\Element\Template
{
	protected $dataHelper;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Blog\BlogModule\Helper\Data $dataHelper
	){
		parent::__construct($context);
		$this->dataHelper = $dataHelper;
	}
	
	public function getBlogLink()
	{
		$blogLink = $this->dataHelper->getStorefrontConfig('blog_link');
		
		return $blogLink;
	}
	
	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}
}