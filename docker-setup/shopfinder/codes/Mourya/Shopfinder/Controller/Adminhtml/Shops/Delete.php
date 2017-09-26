<?php


namespace Mourya\Shopfinder\Controller\Adminhtml\Shops;

class Delete extends \Mourya\Shopfinder\Controller\Adminhtml\Shops
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('shop_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create('Mourya\Shopfinder\Model\Shops');
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('You deleted the Shop.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['shop_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a Shop to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
