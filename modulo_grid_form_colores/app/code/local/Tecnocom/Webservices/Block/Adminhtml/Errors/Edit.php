<?php
class Sminmlc_Webservices_Block_Adminhtml_Errors_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init class
     */
    public function __construct()
    {  
        $this->_blockGroup = 'sminmlc_webservices';
        $this->_controller = 'adminhtml_errors';
     
        parent::__construct();
        
        //Change title buttons
        //$this->_updateButton('save', 'label', $this->__('Save Errors'));
        //$this->_updateButton('delete', 'label', $this->__('Delete Errors'));
        
        //Remove save, delete, and reset button
        $this->_removeButton('save');
		$this->_removeButton('delete');
		$this->_removeButton('reset');
    }  
     
    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {  
        if (Mage::registry('sminmlc_webservices')->getId()) {
            return $this->__('Edit Errors');
        }  
        else {
            return $this->__('New Errors');
        }  
    }  
}
