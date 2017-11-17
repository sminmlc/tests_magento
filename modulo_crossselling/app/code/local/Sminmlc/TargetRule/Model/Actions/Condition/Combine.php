<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */


class Sminmlc_TargetRule_Model_Actions_Condition_Combine extends Mage_Rule_Model_Condition_Combine
{
    /**
     * Set condition type
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType('sminmlc_targetrule/actions_condition_combine');
    }

    /**
     * Prepare list of contitions
     *
     * @return array
     */
    public function getNewChildSelectOptions()
    {
        $conditions = array(
            array('value'=>$this->getType(),
                'label'=>Mage::helper('sminmlc_targetrule')->__('Conditions Combination')),
            Mage::getModel('sminmlc_targetrule/actions_condition_product_attributes')->getNewChildSelectOptions(),
            Mage::getModel('sminmlc_targetrule/actions_condition_product_special')->getNewChildSelectOptions(),
        );
        $conditions = array_merge_recursive(parent::getNewChildSelectOptions(), $conditions);
        return $conditions;
    }

    /**
     * Retrieve SELECT WHERE condition for product collection
     *
     * @param Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection $collection
     * @param Sminmlc_TargetRule_Model_Index $object
     * @param array $bind
     * @return Zend_Db_Expr
     */
    public function getConditionForCollection($collection, $object, &$bind)
    {
        $conditions = array();
        $aggregator = $this->getAggregator() == 'all' ? ' AND ' : ' OR ';
        $operator   = $this->getValue() ? '' : 'NOT';

        foreach ($this->getConditions() as $condition) {
            $subCondition = $condition->getConditionForCollection($collection, $object, $bind);
            if ($subCondition) {
                $conditions[] = sprintf('%s %s', $operator, $subCondition);
            }
        }

        if ($conditions) {
            return new Zend_Db_Expr(sprintf('(%s)', join($aggregator, $conditions)));
        }

        return false;
    }
}

