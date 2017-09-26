<?php


namespace Mourya\Shopfinder\Model;

use Mourya\Shopfinder\Api\Data\ShopsSearchResultsInterfaceFactory;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Mourya\Shopfinder\Model\ResourceModel\Shops as ResourceShops;
use Magento\Framework\Exception\CouldNotSaveException;
use Mourya\Shopfinder\Api\Data\ShopsInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Mourya\Shopfinder\Model\ResourceModel\Shops\CollectionFactory as ShopsCollectionFactory;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Mourya\Shopfinder\Api\ShopsRepositoryInterface;

class ShopsRepository implements shopsRepositoryInterface
{

    protected $shopsCollectionFactory;

    protected $dataObjectProcessor;

    protected $dataObjectHelper;

    protected $searchResultsFactory;

    protected $resource;

    protected $dataShopsFactory;

    protected $shopsFactory;

    private $storeManager;
    private $searchCriteriaBuilder;
    private $request;



    /**
     * @param ResourceShops $resource
     * @param ShopsFactory $shopsFactory
     * @param ShopsInterfaceFactory $dataShopsFactory
     * @param ShopsCollectionFactory $shopsCollectionFactory
     * @param ShopsSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceShops $resource,
        ShopsFactory $shopsFactory,
        ShopsInterfaceFactory $dataShopsFactory,
        ShopsCollectionFactory $shopsCollectionFactory,
        ShopsSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->resource = $resource;
        $this->shopsFactory = $shopsFactory;
        $this->shopsCollectionFactory = $shopsCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataShopsFactory = $dataShopsFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->request = $request;
    }


    public function getLists()
    {
        $storeId = $this->storeManager->getStore()->getId();
        $collection = $this->shopsCollectionFactory->create();
        if ($storeId != 1) {
            $collection->addFieldToFilter('store_id', $storeId);
        }

        $this->searchCriteriaBuilder->create();
        $searchResults = $this->searchResultsFactory->create();

        $criteria = $this->request->get('searchCriteria');
        if (isset($criteria) && !empty($criteria)) {
            if (isset($criteria['filterGroups'][0]['filters']) && !empty($criteria['filterGroups'][0]['filters'])) {
                foreach ($criteria['filterGroups'][0]['filters'] as $filter) {
                    $condition = (isset($filter['condition_type']) && !empty($filter['condition_type'])) ?
                        $filter['condition_type'] : 'eq';
                        if ( $condition == 'like' ) {
                            $filter['value'] = '%' . $filter['value'] . '%';
                        }
                        $collection->addFieldToFilter($filter['field'], [$condition => $filter['value']]);

                    $this->searchCriteriaBuilder->addFilter(
                        $filter['field'],
                        $filter['value'],
                        (isset($filter['condition_type']) && !empty($filter['condition_type'])) ?
                            $filter['condition_type'] : 'eq'
                    );
                }
            }

            if (isset($criteria['current_page']) && !empty($criteria['current_page'])) {
                $collection->setCurPage($criteria['current_page']);
                $this->searchCriteriaBuilder->setCurrentPage($criteria['current_page']);
            }

            if (isset($criteria['page_size']) && !empty($criteria['page_size'])) {
                $collection->setPageSize($criteria['current_page']);
                $this->searchCriteriaBuilder->setPageSize($criteria['page_size']);
            }

            if (isset($criteria['sort_orders']) && !empty($criteria['sort_orders'])) {
                foreach ($criteria['sort_orders'] as $sort) {

                    $collection->addOrder(
                        $sort['field'],
                        ($sort['direction'] == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                    );

                    $this->searchCriteriaBuilder->addSortOrder(
                        $sort['field'],
                        ($sort['direction'] == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                    );
                }
            }

            $searchResults->setSearchCriteria($this->searchCriteriaBuilder->create());
        }

        $collection->load();

        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
