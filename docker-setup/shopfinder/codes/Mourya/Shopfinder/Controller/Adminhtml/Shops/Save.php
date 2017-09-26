<?php


namespace Mourya\Shopfinder\Controller\Adminhtml\Shops;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
     * Image uploader
     *
     * @var \Mourya\Shopfinder\Model\ImageUploader
     */
    protected $imageUploader;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Mourya\Shopfinder\Model\ImageUploader $imageUploader
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->imageUploader = $imageUploader;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('shop_id');
        
            $model = $this->_objectManager->create('Mourya\Shopfinder\Model\Shops')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This Shop no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            
            $data['image'] = $this->imageUploader->uploadFileAndGetName('image', $data);
            $model->setData($data);
        
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the Shop.'));
                $this->dataPersistor->clear('mourya_shopfinder_shops');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['shop_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Shop.'));
            }
        
            $this->dataPersistor->set('mourya_shopfinder_shops', $data);
            return $resultRedirect->setPath('*/*/edit', ['shop_id' => $this->getRequest()->getParam('shop_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }


    
}
