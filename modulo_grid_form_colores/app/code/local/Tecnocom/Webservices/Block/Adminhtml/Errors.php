<?php
class Sminmlc_Webservices_Block_Adminhtml_Errors extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'sminmlc_webservices';
        $this->_controller = 'adminhtml_errors';
        $this->_headerText = $this->__('Webservices errors');
        
		//Add export button
		$this->_addButton('export', array(
			'label'   => Mage::helper('catalog')->__('Export Errors'),
			'onclick' => "setLocation('{$this->getUrl('*/*/export')}')"
    	));
		
        parent::__construct();
		
		//Remove add button
		$this->_removeButton('add');
    }
}
