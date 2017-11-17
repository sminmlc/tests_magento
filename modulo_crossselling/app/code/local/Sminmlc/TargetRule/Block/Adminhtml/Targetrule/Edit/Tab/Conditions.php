<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */


/**
 * TargetRule Adminhtml Edit Tab Conditions Block
 *
 * @category   Sminmlc
 * @package    Sminmlc_TargetRule
 */
class Sminmlc_TargetRule_Block_Adminhtml_Targetrule_Edit_Tab_Conditions
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepare target rule actions form before rendering HTML
     *
     * @return Sminmlc_TargetRule_Block_Adminhtml_Targetrule_Edit_Tab_Conditions
     */
    protected function _prepareForm()
    {
        /* @var $model Sminmlc_TargetRule_Model_Rule */
        $model  = Mage::registry('current_target_rule');

        $form   = new Varien_Data_Form();
        $form->setHtmlIdPrefix('rule_');

        $fieldset   = $form->addFieldset('conditions_fieldset', array(
            'legend' => Mage::helper('sminmlc_targetrule')->__('Product Match Conditions (leave blank for matching all products)'))
        );
        $newCondUrl = $this->getUrl('*/targetrule/newConditionHtml/', array(
            'form'  => $fieldset->getHtmlId()
        ));
        $renderer   = Mage::getBlockSingleton('adminhtml/widget_form_renderer_fieldset')
            ->setTemplate('sminmlc/targetrule/edit/conditions/fieldset.phtml')
            ->setNewChildUrl($newCondUrl);
        $fieldset->setRenderer($renderer);

        $element    = $fieldset->addField('conditions', 'text', array(
            'name'      => 'conditions',
            'required'  => true,
        ));

        $element->setRule($model);
        $element->setRenderer(Mage::getBlockSingleton('sminmlc_targetrule/adminhtml_rule_conditions'));

        $model->getConditions()->setJsFormObject($fieldset->getHtmlId());
        $form->setValues($model->getData());

        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Retrieve Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('sminmlc_targetrule')->__('Products to Match');
    }

    /**
     * Retrieve Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('sminmlc_targetrule')->__('Products to Match');
    }

    /**
     * Check is can show tab
     *
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Check tab is hidden
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }
}
