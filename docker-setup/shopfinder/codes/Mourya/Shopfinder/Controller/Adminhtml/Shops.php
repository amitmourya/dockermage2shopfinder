<?php


namespace Mourya\Shopfinder\Controller\Adminhtml;

abstract class Shops extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Mourya_Shopfinder::top_level';
    protected $_coreRegistry;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Experius_Test::top_level')
            ->addBreadcrumb(__('Mourya'), __('Mourya'))
            ->addBreadcrumb(__('Shops'), __('Shops'));
        return $resultPage;
    }
}
