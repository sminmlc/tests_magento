<?php
class Sminmlc_Webservices_Adminhtml_ErrorsController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        // Let's call our initAction method which will set some basic params for each action
        $this->_initAction()->renderLayout();
    }  
     
    public function newAction()
    {
        $this->_forward('edit');
    }  
    
    public function exportAction(){
        Mage::dispatchEvent('export_errors');
        Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The errors has been exported to email.'));
        $this->_redirect('*/errors/');
        
    }
    
    public function editAction()
    {  
        $this->_initAction();
     
        // Get id if available
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('sminmlc_webservices/webservices');
     
        if ($id) {
            // Load record
            $model->load($id);
     
            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This errors no longer exists.'));
                $this->_redirect('*/*/');
     
                return;
            }  
        }  
     
        $this->_title($model->getId() ? $model->getName() : $this->__('New errors'));
     
        $data = Mage::getSingleton('adminhtml/session')->geterrorsData(true);
        if (!empty($data)) {
            $model->setData($data);
        }  
     
        Mage::register('sminmlc_webservices', $model);
     
        $this->_initAction()
            ->_addBreadcrumb($id ? $this->__('Edit errors') : $this->__('New errors'), $id ? $this->__('Edit errors') : $this->__('New errors'))
            ->_addContent($this->getLayout()->createBlock('sminmlc_webservices/adminhtml_errors_edit')->setData('action', $this->getUrl('*/*/save')))
            ->renderLayout();
    }
    
    public function deleteAction()
    {
        $this->_initAction();
     
        // Get id if available
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('sminmlc_webservices/webservices');
     
        if ($id) {
            // Load record
            $model->load($id);
     
            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This errors no longer exists.'));
                $this->_redirect('*/*/');
     
                return;
            }  
        }  
        $model->setId($id)->delete();
        Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The errors has been deleted.'));
        $this->_redirect('*/*/');
        
    }
    
    public function saveAction()
    {
        if ($postData = $this->getRequest()->getPost()) {
            $model = Mage::getSingleton('sminmlc_webservices/webservices');
            $model->setData($postData);
 
            try {
                $model->save();
 
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The errors has been saved.'));
                $this->_redirect('*/*/');
 
                return;
            }  
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this errors.'));
            }
 
            Mage::getSingleton('adminhtml/session')->seterrorsData($postData);
            $this->_redirectReferer();
        }
    }
     
    public function messageAction()
    {
        $data = Mage::getModel('sminmlc_webservices/webservices')->load($this->getRequest()->getParam('id'));
        echo $data->getContent();
    }
     
    /**
     * Initialize action
     *
     * Here, we set the breadcrumbs and the active menu
     *
     * @return Mage_Adminhtml_Controller_Action
     */
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('sminmlc_webservices_errors')
            ->_title($this->__('EWSlog'))
            ->_addBreadcrumb($this->__(''), $this->__('EWSlog'));
         
        return $this;
    }
}
