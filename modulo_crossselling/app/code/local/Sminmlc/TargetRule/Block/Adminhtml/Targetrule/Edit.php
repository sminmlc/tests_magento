<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

/**
 * Target rule edit form block
 */

class Sminmlc_TargetRule_Block_Adminhtml_Targetrule_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected $_blockGroup = 'sminmlc_targetrule';
    protected $_controller = 'adminhtml_targetrule';

    /**
     * Initialize form
     * Add standard buttons
     * Add "Save and Continue" button
     */
    public function __construct()
    {
        parent::__construct();

        $this->_addButton('save_and_continue_edit', array(
            'class'   => 'save',
            'label'   => Mage::helper('sminmlc_targetrule')->__('Save and Continue Edit'),
            'onclick' => 'editForm.submit($(\'edit_form\').action + \'back/edit/\')',
        ), 3);
    }

    /**
     * Getter for form header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        $rule = Mage::registry('current_target_rule');
        if ($rule && $rule->getRuleId()) {
            return Mage::helper('sminmlc_targetrule')->__("Edit Rule '%s'", $this->escapeHtml($rule->getName()));
        }
        else {
            return Mage::helper('sminmlc_targetrule')->__('New Rule');
        }
    }

}
