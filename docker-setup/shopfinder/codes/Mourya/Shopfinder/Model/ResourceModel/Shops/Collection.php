<?php


namespace Mourya\Shopfinder\Model\ResourceModel\Shops;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Mourya\Shopfinder\Model\Shops',
            'Mourya\Shopfinder\Model\ResourceModel\Shops'
        );
    }
}
