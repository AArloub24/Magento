<?php
namespace Blog\BlogModule\Model\ResourceModel\Allblog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'blog_id';
	
	protected $_eventPrefix = 'blog_allblog_collection';

    protected $_eventObject = 'allblog_collection';
	
	/**
     * Define model & resource model
     */
	protected function _construct()
	{
		$this->_init('Blog\BlogModule\Model\Allblog', 'Blog\BlogModule\Model\ResourceModel\Allblog');
	}
}