<?php


namespace Mourya\Shopfinder\Model\Shops;

use Magento\Framework\App\Request\DataPersistorInterface;
use Mourya\Shopfinder\Model\ResourceModel\Shops\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $dataPersistor;

    protected $collection;

    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $blockCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        \Mourya\Shopfinder\Model\ImageUploader $imageUploader,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->imageUploader = $imageUploader;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
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
        foreach ($items as $model) {
            $modelData = $model->getData();
            
            if ($model->getImage()) {
                $image = [];
                $image[0]['name'] = $model->getImage();
                $image[0]['url'] = $this->imageUploader->getImageDirectoryPath().$model->getImage();
                $modelData['image'] = $image;
            }

            $this->loadedData[$model->getId()] = $modelData;
        }
        $data = $this->dataPersistor->get('mourya_shopfinder_shops');
        
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('mourya_shopfinder_shops');
        }
        
        return $this->loadedData;
    }
}
