<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */


class Sminmlc_TargetRule_Model_Rule_Condition_Product_Attributes
    extends Mage_Rule_Model_Condition_Product_Abstract
{
    /**
     * Attribute property that defines whether to use it for target rules
     *
     * @var string
     */
    protected $_isUsedForRuleProperty = 'is_used_for_promo_rules';

    /**
     * Target rule codes that do not allowed to select
     * Products with status 'disabled' cannot be shown as related/cross-sells/up-sells thus rule code is useless
     *
     * @var array
     */
    protected $_disabledTargetRuleCodes = array(
        'status'
    );

    /**
     * Set condition type and value
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType('sminmlc_targetrule/rule_condition_product_attributes');
        $this->setValue(null);
    }

    /**
     * Prepare child rules option list
     *
     * @return array
     */
    public function getNewChildSelectOptions()
    {
        $attributes = $this->loadAttributeOptions()->getAttributeOption();
        $conditions = array();
        foreach ($attributes as $code => $label) {
            if (! in_array($code, $this->_disabledTargetRuleCodes)) {
                $conditions[] = array(
                    'value' => $this->getType() . '|' . $code,
                    'label' => $label
                );
            }
        }

        return array(
            'value' => $conditions,
            'label' => Mage::helper('sminmlc_targetrule')->__('Product Attributes')
        );
    }
}
