<?php
namespace Test\News\Model\Allnews;
use Test\News\Model\ResourceModel\Allnews\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
/**
* Class DataProvider
*/
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
   /**
    * @var \Test\News\Model\ResourceModel\Allnews\Collection
    */
   protected $collection;
   /**
    * @var DataPersistorInterface
    */
   protected $dataPersistor;
   /**
    * @var array
    */
   protected $loadedData;
   /**
    * @param string $name
    * @param string $primaryFieldName
    * @param string $requestFieldName
    * @param CollectionFactory $allnewsCollectionFactory
    * @param DataPersistorInterface $dataPersistor
    * @param array $meta
    * @param array $data
    */
   public function __construct(
       $name,
       $primaryFieldName,
       $requestFieldName,
       CollectionFactory $allblogCollectionFactory,
       DataPersistorInterface $dataPersistor,
       array $meta = [],
       array $data = []
   ) {
       $this->collection = $allblogCollectionFactory->create();
       $this->dataPersistor = $dataPersistor;
       parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
       $this->meta = $this->prepareMeta($this->meta);
   }
   /**
    * Prepares Meta
    *
    * @param array $meta
    * @return array
    */
   public function prepareMeta(array $meta)
   {
       return $meta;
   }
   /**
    * Get data
    *
    * @return array
    */
   public function getData()
   {
       if (isset($this->loadedData)) {
           return $this->loadedData;
       }
       $items = $this->collection->getItems();
       /** @var $blog \Test\News\Model\Allnews */
       foreach ($items as $blog) {
           $this->loadedData[$blog->getId()] = $blog->getData();
       }
       $data = $this->dataPersistor->get('test_news');
       if (!empty($data)) {
           $blog = $this->collection->getNewEmptyItem();
           $blog->setData($data);
           $this->loadedData[$blog->getId()] = $blog->getData();
           $this->dataPersistor->clear('test_news');
       }
       return $this->loadedData;
   }
}