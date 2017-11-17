<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

/**
 * Sminmlc TargetRule left-navigation block
 *
 */
class Sminmlc_TargetRule_Block_Adminhtml_Targetrule_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('targetrule_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('sminmlc_targetrule')->__('Product Rule Information'));
    }
}
