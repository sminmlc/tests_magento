<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */


class Sminmlc_TargetRule_Model_Rule_Condition_Combine extends Mage_Rule_Model_Condition_Combine
{
    /**
     * Set condition type
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType('sminmlc_targetrule/rule_condition_combine');
    }

    /**
     * Prepare list of contitions
     *
     * @return array
     */
    public function getNewChildSelectOptions()
    {
        $conditions = array(
            array(
                'value' => $this->getType(),
                'label' => Mage::helper('sminmlc_targetrule')->__('Conditions Combination')
            ),
            Mage::getModel('sminmlc_targetrule/rule_condition_product_attributes')->getNewChildSelectOptions(),
        );

        $conditions = array_merge_recursive(parent::getNewChildSelectOptions(), $conditions);
        return $conditions;
    }

    /**
     * Collect validated attributes for Product Collection
     *
     * @param Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection $productCollection
     * @return Sminmlc_TargetRule_Model_Rule_Condition_Combine
     */
    public function collectValidatedAttributes($productCollection)
    {
        foreach ($this->getConditions() as $condition) {
            $condition->collectValidatedAttributes($productCollection);
        }
        return $this;
    }
}
