<?php
class Sminmlc_Webservices_Block_Adminhtml_Errors_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init class
     */
    public function __construct()
    {  
        parent::__construct();
     
        $this->setId('sminmlc_webservices_errors_form');
        $this->setTitle($this->__('Errors Information'));
    }  
     
    /**
     * Setup form fields for inserts/updates
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {  
        $model = Mage::registry('sminmlc_webservices');
     
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post'
        ));
     
        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('checkout')->__('Errors Information'),
            'class'     => 'fieldset-wide',
        ));
     
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
        }
        
        $order = Mage::getModel('sales/order')->loadByIncrementId($model->getData('increment_id'));
        $fieldset->addField('increment_id', 'link', array(
            'name'      => 'increment_id',
            'href'      => $this->getUrl('adminhtml/sales_order/view', array('order_id' => $order->getId(), 'key' => $this->getCacheKey())),
            'value'     => $model->getData('increment_id'),
            'label'     => Mage::helper('checkout')->__('Order id'),
            'title'     => Mage::helper('checkout')->__('Order id'),
        ));
        
        $fieldset->addField('id_error', 'label', array(
            'name'      => 'id_error',
            'label'     => Mage::helper('checkout')->__('ID error'),
            'title'     => Mage::helper('checkout')->__('ID error'),
            'required'  => false,
        ));
       
        $fieldset->addField('date', 'label', array(
            'name'      => 'date',
            'label'     => Mage::helper('checkout')->__('Date'),
            'title'     => Mage::helper('checkout')->__('Date'),
            'required'  => false,
        ));
        
        $fieldset->addField('priority', 'label', array(
            'name'      => 'priority',
            'label'     => Mage::helper('checkout')->__('Priority'),
            'title'     => Mage::helper('checkout')->__('Priority'),
            'required'  => false,
        ));
        
        $fieldset->addField('ws_method', 'label', array(
            'name'      => 'ws_method',
            'label'     => Mage::helper('checkout')->__('WS method'),
            'title'     => Mage::helper('checkout')->__('WS method'),
            'required'  => false,
        ));
        
        $fieldset->addField('desc_error', 'label', array(
            'name'      => 'desc_error',
            'label'     => Mage::helper('checkout')->__('Description'),
            'title'     => Mage::helper('checkout')->__('Description'),
            'required'  => false,
        ));
        
        $fieldset->addField('trace_input', 'label', array(
            'name'      => 'trace_input',
            'label'     => Mage::helper('checkout')->__('Trace input'),
            'title'     => Mage::helper('checkout')->__('Trace input'),
            'required'  => false,
        ));
        
        $fieldset->addField('trace_output', 'label', array(
            'name'      => 'trace_output',
            'label'     => Mage::helper('checkout')->__('Trace output'),
            'title'     => Mage::helper('checkout')->__('Trace output'),
            'required'  => false,
        ));
        
        $fieldset->addField('others', 'label', array(
            'name'      => 'others',
            'label'     => Mage::helper('checkout')->__('Others'),
            'title'     => Mage::helper('checkout')->__('Others'),
            'required'  => false,
        ));
        
        $fieldset->addField('paid', 'label', array(
            'name'      => 'paid',
            'label'     => Mage::helper('checkout')->__('Paid'),
            'title'     => Mage::helper('checkout')->__('Paid'),
            'required'  => false,
        ));
        
        $fieldset->addField('transaction_code', 'label', array(
            'name'      => 'transaction_code',
            'label'     => Mage::helper('checkout')->__('Transaction code'),
            'title'     => Mage::helper('checkout')->__('Transaction code'),
            'required'  => false,
        ));
        
        $fieldset->addField('customer', 'link', array(
            'name'      => 'customer',
            'href'      => $this->getUrl('*/customer/edit', array('id' => $order->getCustomerId())),
            'value'     => $model->getData('customer'),
            'label'     => Mage::helper('checkout')->__('Customer'),
            'title'     => Mage::helper('checkout')->__('Customer'),
        ));
        
        $fieldset->addField('timestamp', 'label', array(
            'name'      => 'timestamp',
            'label'     => Mage::helper('checkout')->__('Timestamp'),
            'title'     => Mage::helper('checkout')->__('Timestamp'),
            'required'  => false,
        ));
        
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
     
        return parent::_prepareForm();
    }  
}
