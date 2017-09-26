<?php


namespace Mourya\Shopfinder\Controller\Adminhtml\Shops;

class MassDelete extends \Mourya\Shopfinder\Controller\Adminhtml\Shops
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            // check if we know what should be deleted
            $selected = $this->getRequest()->getParam('selected');
            if($selected){
                foreach ($selected as $value) {
                    $model = $this->_objectManager->create('Mourya\Shopfinder\Model\Shops');
                    $model->load($value);
                    if($model){
                        $model->delete();
                    }
                }

            }
            $this->messageManager->addSuccess(__('You deleted the Shops.'));
            return $resultRedirect->setPath('*/*/');
        } catch (Exception $e) {
            $this->messageManager->addError($e->getMessage());
            return $resultRedirect->setPath('*/*/');
        }
    }
}
