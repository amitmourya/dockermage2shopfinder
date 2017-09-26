<?php


namespace Mourya\Shopfinder\Api\Data;

interface ShopsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get shops list.
     * @return \Mourya\Shopfinder\Api\Data\ShopsInterface[]
     */
    
    public function getItems();

    /**
     * Set name list.
     * @param \Mourya\Shopfinder\Api\Data\ShopsInterface[] $items
     * @return $this
     */
    
    public function setItems(array $items);
}
