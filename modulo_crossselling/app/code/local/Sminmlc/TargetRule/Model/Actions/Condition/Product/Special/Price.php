<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */


/**
 * TargetRule Action Product Price (percentage) Condition Model
 *
 * @category   Sminmlc
 * @package    Sminmlc_TargetRule
 */
class Sminmlc_TargetRule_Model_Actions_Condition_Product_Special_Price
    extends Sminmlc_TargetRule_Model_Actions_Condition_Product_Special
{
    /**
     * Set rule type
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType('sminmlc_targetrule/actions_condition_product_special_price');
        $this->setValue(100);
    }

    /**
     * Retrieve operator select options array
     *
     * @return array
     */
    protected function _getOperatorOptionArray()
    {
        return array(
            '==' => Mage::helper('sminmlc_targetrule')->__('equal to'),
            '>'  => Mage::helper('sminmlc_targetrule')->__('more'),
            '>=' => Mage::helper('sminmlc_targetrule')->__('equals or greater than'),
            '<'  => Mage::helper('sminmlc_targetrule')->__('less'),
            '<=' => Mage::helper('sminmlc_targetrule')->__('equals or less than')
        );
    }

    /**
     * Set operator options
     *
     * @return Sminmlc_TargetRule_Model_Actions_Condition_Product_Special_Price
     */
    public function loadOperatorOptions()
    {
        parent::loadOperatorOptions();
        $this->setOperatorOption($this->_getOperatorOptionArray());
        return $this;
    }

    /**
     * Retrieve rule as HTML formated string
     *
     * @return string
     */
    public function asHtml()
    {
        return $this->getTypeElementHtml()
            . Mage::helper('sminmlc_targetrule')->__('Product Price is %s %s%% of Matched Product(s) Price', $this->getOperatorElementHtml(), $this->getValueElementHtml())
            . $this->getRemoveLinkHtml();
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
        /* @var $resource Sminmlc_TargetRule_Model_Mysql4_Index */
        $resource       = $object->getResource();
        $operator       = $this->getOperator();

        $where = $resource->getOperatorBindCondition('price_index.min_price', 'final_price', $operator, $bind,
            array(array('bindPercentOf', $this->getValue())));
        return new Zend_Db_Expr(sprintf('(%s)', $where));
    }
}
