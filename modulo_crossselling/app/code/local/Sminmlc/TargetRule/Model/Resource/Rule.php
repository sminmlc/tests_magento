<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */


/**
 * TargetRule Rule Resource Model
 *
 * @category    Sminmlc
 * @package     Sminmlc_TargetRule
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sminmlc_TargetRule_Model_Resource_Rule extends Mage_Rule_Model_Resource_Abstract
{
    /**
     * Store associated with rule entities information map
     *
     * @var array
     */
    protected $_associatedEntitiesMap = array(
        'product' => array(
            'associations_table' => 'sminmlc_targetrule/product',
            'rule_id_field'      => 'rule_id',
            'entity_id_field'    => 'product_id'
        )
    );

   /**
    * Initialize main table and table id field
    */
    protected function _construct()
    {
        $this->_init('sminmlc_targetrule/rule', 'rule_id');
    }

    /**
     * Get Customer Segment Ids by rule
     *
     * @param Mage_Core_Model_Abstract $object
     * @return array
     */
    public function getCustomerSegmentIds(Mage_Core_Model_Abstract $object)
    {
        $ids = $this->getReadConnection()->select()
            ->from($this->getTable('sminmlc_targetrule/customersegment'), 'segment_id')
            ->where('rule_id = ?', $object->getId())
            ->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return empty($ids) ? array() : $ids;
    }

    /**
     * Remove Product From Rules
     *
     * @param int $productId
     */
    public function removeProductFromRules($productId)
    {
        $this->_getWriteAdapter()->delete(
            $this->getTable('sminmlc_targetrule/product'),
            'product_id = ' . $this->_getWriteAdapter()->quote($productId)
        );
    }

    /**
     * Bind rule to customer segments
     *
     * @param int $ruleId
     * @param array $segmentIds
     * @return Sminmlc_TargetRule_Model_Resource_Rule
     */
    public function saveCustomerSegments($ruleId, $segmentIds)
    {
        if (empty($segmentIds)) {
            $segmentIds = array();
        }
        $adapter = $this->_getWriteAdapter();
        foreach ($segmentIds as $segmentId) {
            if (!empty($segmentId)) {
                $adapter->insertOnDuplicate($this->getTable('sminmlc_targetrule/customersegment'),
                    array('rule_id' => $ruleId, 'segment_id' => $segmentId),
                    array()
                );
            }
        }

        if (empty($segmentIds)) {
            $segmentIds = array(0);
        }

        $adapter->delete($this->getTable('sminmlc_targetrule/customersegment'),
            array('rule_id = ?' => $ruleId, 'segment_id NOT IN (?)' => $segmentIds));
        return $this;
    }

    /**
     * Add customer segment ids to rule
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        $object->setData('customer_segment_ids', $this->getCustomerSegmentIds($object));
        return parent::_afterLoad($object);
    }

    /**
     * Save matched products for current rule and clean index
     *
     * @param Mage_Core_Model_Abstract|Sminmlc_TargetRule_Model_Rule $object
     *
     * @return Sminmlc_TargetRule_Model_Resource_Rule
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        parent::_afterSave($object);
        $segmentIds = $object->getUseCustomerSegment() ? $object->getCustomerSegmentIds() : array(0);
        $this->saveCustomerSegments($object->getId(), $segmentIds);

        $this->unbindRuleFromEntity($object->getId(), array(), 'product');
        /** @var $catalogFlatHelper Mage_Catalog_Helper_Product_Flat */
        $catalogFlatHelper = Mage::helper('catalog/product_flat');
        $storeView = Mage::app()->getDefaultStoreView();
        if ($storeView)
            $storeId = $storeView->getId();
        else
            $storeId = null;

        if ($catalogFlatHelper->isEnabled() && $catalogFlatHelper->isBuilt($storeId)) {
            $this->_fillProductsByRule($object);
        } else {
            $this->bindRuleToEntity($object->getId(), $object->getMatchingProductIds(), 'product');
        }

        return $this;
    }

    /**
     * Insert data for rule
     *
     * @param Sminmlc_TargetRule_Model_Rule $rule
     */
    protected function _fillProductsByRule(Sminmlc_TargetRule_Model_Rule $rule)
    {
        foreach (Mage::app()->getStores(false) as $store) {
            /** @var $store Mage_Core_Model_Store */
            $productIdsSelect = $rule->getProductFlatSelect($store->getId());
            $productIdsSelect->columns(
                array(
                    'rule_id' => new Zend_Db_Expr(
                        $rule->getId()
                    )
                )
            );

            $this->_getWriteAdapter()->query(
                $this->_getWriteAdapter()->insertFromSelect(
                    $productIdsSelect,
                    $this->getTable('sminmlc_targetrule/product'),
                    array('product_id', 'rule_id'),
                    Varien_Db_Adapter_Interface::INSERT_IGNORE
                )
            );
        }
    }

    /**
     * Prepare and Save Matched products for Rule
     *
     * @deprecated after 1.11.2.0
     *
     * @param Sminmlc_TargetRule_Model_Rule $object
     *
     * @return Sminmlc_TargetRule_Model_Resource_Rule
     */
    protected function _prepareRuleProducts($object)
    {
        $this->unbindRuleFromEntity($object->getId(), array(), 'product');
        $this->bindRuleToEntity($object->getId(), $object->getMatchingProductIds(), 'product');

        return $this;
    }

    /**
     * Save Customer Segment Relations
     *
     * @deprecated after 1.11.2.0
     *
     * @param Mage_Core_Model_Abstract|Sminmlc_TargetRule_Model_Rule $object
     *
     * @return Sminmlc_TargetRule_Model_Resource_Rule
     */
    protected function _saveCustomerSegmentRelations(Mage_Core_Model_Abstract $object)
    {
        return $this;
    }

    /**
     * Retrieve target rule and customer segment relations table name
     *
     * @deprecated after 1.11.2.0
     *
     * @return string
     */
    protected function _getCustomerSegmentRelationsTable()
    {
        return '';
    }

    /**
     * Retrieve customer segment relations by target rule id
     *
     * @deprecated after 1.11.2.0
     *
     * @param int $ruleId
     *
     * @return array
     */
    public function getCustomerSegmentRelations($ruleId)
    {
        return array();
    }

    /**
     * Add Customer segment relations to Rule Resource Collection
     *
     * @deprecated after 1.11.2.0
     *
     * @param Mage_Core_Model_Mysql4_Collection_Abstract $collection
     *
     * @return Sminmlc_TargetRule_Model_Resource_Rule
     */
    public function addCustomerSegmentRelationsToCollection(Mage_Core_Model_Mysql4_Collection_Abstract $collection)
    {
        return $this;
    }

    /**
     * Retrieve target rule matched by condition products table name
     *
     * @deprecated after 1.11.2.0
     *
     * @return string
     */
    protected function _getRuleProductsTable()
    {
        return $this->getTable('sminmlc_targetrule/product');
    }
}
