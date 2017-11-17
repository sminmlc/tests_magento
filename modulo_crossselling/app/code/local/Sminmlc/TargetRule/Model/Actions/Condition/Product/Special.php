<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */


/**
 * TargetRule Action Special Product Attributes Condition Model
 *
 * @category   Sminmlc
 * @package    Sminmlc_TargetRule
 */
class Sminmlc_TargetRule_Model_Actions_Condition_Product_Special
    extends Mage_Rule_Model_Condition_Product_Abstract
{
    /**
     * Set condition type and value
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType('sminmlc_targetrule/actions_condition_product_special');
        $this->setValue(null);
    }

    /**
     * Get inherited conditions selectors
     *
     * @return array
     */
    public function getNewChildSelectOptions()
    {
        $conditions = array(
            array(
                'value' => 'sminmlc_targetrule/actions_condition_product_special_price',
                'label' => Mage::helper('sminmlc_targetrule')->__('Price (percentage)')
            )
        );

        return array(
            'value' => $conditions,
            'label' => Mage::helper('sminmlc_targetrule')->__('Product Special')
        );
    }
}
