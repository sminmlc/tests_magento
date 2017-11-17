<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

/**
 * TargetRule observer
 *
 */
class Sminmlc_TargetRule_Model_Observer
{
    /**
     * Prepare target rule data
     *
     * @param Varien_Event_Observer $observer
     */
    public function prepareTargetRuleSave(Varien_Event_Observer $observer)
    {
        $_vars = array('targetrule_rule_based_positions', 'tgtr_position_behavior');
        $_varPrefix = array('related_', 'upsell_', 'crosssell_');
        if ($product = $observer->getEvent()->getProduct()) {
            foreach ($_vars as $var) {
                foreach ($_varPrefix as $pref) {
                    $v = $pref . $var;
                    if ($product->getData($v.'_default') == 1) {
                        $product->setData($v, null);
                    }
                }
            }
        }
    }

    /**
     * Process event on 'save_commit_after' event. Rebuild product index by rule conditions
     *
     * @param Varien_Event_Observer $observer
     */
    public function catalogProductSaveCommitAfter(Varien_Event_Observer $observer)
    {
        /** @var $product Mage_Catalog_Model_Product */
        $product = $observer->getEvent()->getProduct();

        /** @var \Mage_Index_Model_Indexer $indexer */
        $indexer = Mage::getSingleton('index/indexer');
        $indexer->processEntityAction(
            new Varien_Object(
                array(
                    'id' => $product->getId(),
                    'store_id' => $product->getStoreId(),
                    'rule' => $product->getData('rule'),
                    'from_date' => $product->getData('from_date'),
                    'to_date' => $product->getData('to_date')
                )
            ),
            Sminmlc_TargetRule_Model_Index::ENTITY_PRODUCT,
            Sminmlc_TargetRule_Model_Index::EVENT_TYPE_REINDEX_PRODUCTS
        );

        // check for upsell(s) products if any
        $this->refreshUpSells($product);

    }

    /**
     * ReIndex UpSells for the product
     *
     * @param Mage_Catalog_Model_Product $product
     */
    protected function refreshUpSells(Mage_Catalog_Model_Product $product)
    {
        $upSellCollection = $product->getUpSellProductCollection();

        if($upSellCollection->count() > 0){
            /** @var \Mage_Index_Model_Indexer $indexer */
            $indexer = Mage::getSingleton('index/indexer');

            foreach($upSellCollection as $product){
                $indexer->processEntityAction(
                    new Varien_Object(
                        array(
                            'id' => $product->getId(),
                            'store_id' => $product->getStoreId(),
                            'rule' => $product->getData('rule'),
                            'from_date' => $product->getData('from_date'),
                            'to_date' => $product->getData('to_date')
                        )
                    ),
                    Sminmlc_TargetRule_Model_Index::ENTITY_PRODUCT,
                    Sminmlc_TargetRule_Model_Index::EVENT_TYPE_REINDEX_PRODUCTS
                );
            }
        }
    }

    /**
     * Clear customer segment indexer if customer segment is on|off on backend
     *
     * @param Varien_Event_Observer $observer
     * @return Sminmlc_TargetRule_Model_Observer
     */
    public function coreConfigSaveCommitAfter(Varien_Event_Observer $observer)
    {
        if ($observer->getDataObject()->getPath() == 'customer/sminmlc_customersegment/is_enabled'
            && $observer->getDataObject()->isValueChanged()) {
            Mage::getSingleton('index/indexer')->logEvent(
                new Varien_Object(array('type_id' => null, 'store' => null)),
                Sminmlc_TargetRule_Model_Index::ENTITY_TARGETRULE,
                Sminmlc_TargetRule_Model_Index::EVENT_TYPE_CLEAN_TARGETRULES
            );
            Mage::getSingleton('index/indexer')->indexEvents(
                Sminmlc_TargetRule_Model_Index::ENTITY_TARGETRULE,
                Sminmlc_TargetRule_Model_Index::EVENT_TYPE_CLEAN_TARGETRULES
            );
        }
        return $this;
    }
}
