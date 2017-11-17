<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

class Sminmlc_TargetRule_Block_Adminhtml_Targetrule extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Initialize invitation manage page
     *
     * @return void
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_targetrule';
        $this->_blockGroup = 'sminmlc_targetrule';
        $this->_headerText = Mage::helper('sminmlc_targetrule')->__('Manage Product Rules');
        $this->_addButtonLabel = Mage::helper('sminmlc_targetrule')->__('Add Rule');
        parent::__construct();
    }

}
