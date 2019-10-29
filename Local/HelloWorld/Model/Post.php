<?php
namespace Local\HelloWorld\Model;
class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'local_helloworld_post';

	protected $_cacheTag = 'local_helloworld_post';

	protected $_eventPrefix = 'local_helloworld_post';

	protected function _construct()
	{
		$this->_init('local\HelloWorld\Model\ResourceModel\Post');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}
