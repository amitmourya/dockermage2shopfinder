<?php

namespace Mourya\Shopfinder\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ShopsRepositoryInterface
{

    /**
     * Retrieve shops matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Mourya\Shopfinder\Api\Data\ShopsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getLists();
}
