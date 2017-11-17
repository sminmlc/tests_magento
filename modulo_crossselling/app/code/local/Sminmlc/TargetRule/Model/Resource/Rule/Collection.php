<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */


/**
 * Target rules resource collection model
 *
 * @category    Sminmlc
 * @package     Sminmlc_TargetRule
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sminmlc_TargetRule_Model_Resource_Rule_Collection extends Mage_Rule_Model_Resource_Rule_Collection_Abstract
{
    /**
     * Set resource model
     */
    protected function _construct()
    {
        $this->_init('sminmlc_targetrule/rule');
    }

    /**
     * Run "afterLoad" callback on items if it is applicable
     *
     * @return Sminmlc_TargetRule_Model_Resource_Rule_Collection
     */
    protected function _afterLoad()
    {
        foreach ($this->_items as $rule) {
            /* @var $rule Sminmlc_TargetRule_Model_Rule */
            if (!$this->getFlag('do_not_run_after_load')) {
                $rule->afterLoad();
            }
        }

        parent::_afterLoad();
        return $this;
    }

    /**
     * Add Apply To Product List Filter to Collection
     *
     * @param int|array $applyTo
     *
     * @return Sminmlc_TargetRule_Model_Resource_Rule_Collection
     */
    public function addApplyToFilter($applyTo)
    {
        $this->addFieldToFilter('apply_to', $applyTo);
        return $this;
    }

    /**
     * Set Priority Sort order
     *
     * @param string $direction
     *
     * @return Sminmlc_TargetRule_Model_Resource_Rule_Collection
     */
    public function setPriorityOrder($direction = self::SORT_ORDER_ASC)
    {
        $this->setOrder('sort_order', $direction);
        return $this;
    }

    /**
     * Add filter by product id to collection
     *
     * @param int $productId
     *
     * @return Sminmlc_TargetRule_Model_Resource_Rule_Collection
     */
    public function addProductFilter($productId)
    {
        $this->getSelect()->join(
            array('product_idx' => $this->getTable('sminmlc_targetrule/product')),
            'product_idx.rule_id = main_table.rule_id',
            array()
        )
        ->where('product_idx.product_id = ?', $productId);

        return $this;
    }

    /**
     * Remove Product From Rules
     *
     * @param int $productId
     */
    public function removeProductFromRules($productId)
    {
        $resource = $this->getResource();
        /** @var $resource Sminmlc_TargetRule_Model_Resource_Rule */
        $resource->removeProductFromRules($productId);
    }

    /**
     * Add filter by segment id to collection
     *
     * @param int $segmentId
     *
     * @return Sminmlc_TargetRule_Model_Resource_Rule_Collection
     */
    public function addSegmentFilter($segmentId)
    {
        if (!empty($segmentId)) {
            $this->getSelect()->join(
                array('segement_idx' => $this->getTable('sminmlc_targetrule/segment')),
                'segement_idx.rule_id = main_table.rule_id', array())->where('segement_idx.segment_id = ?', $segmentId);
        } else {
            $this->getSelect()->joinLeft(
                array('segement_idx' => $this->getTable('sminmlc_targetrule/segment')),
                'segement_idx.rule_id = main_table.rule_id', array())->where('segement_idx.segment_id IS NULL');
        }
        return $this;
    }
}
