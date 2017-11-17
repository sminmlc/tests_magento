<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */


/**
 * TargetRule Products Item Block
 *
 * @category   Sminmlc
 * @package    Sminmlc_TargetRule
 *
 * @method Sminmlc_TargetRule_Block_Catalog_Product_Item setItem(Mage_Catalog_Model_Product $item)
 * @method Mage_Catalog_Model_Product getItem()
 */
class Sminmlc_TargetRule_Block_Catalog_Product_Item extends Mage_Catalog_Block_Product_Abstract
{
    /**
     * Get cache key informative items with the position number to differentiate
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        $cacheKeyInfo = parent::getCacheKeyInfo();
        $elements = Mage::app()->getLayout()->getXpath('//action[@method="addPriceBlockType"]');
        if (is_array($elements)) {
            foreach ($elements as $element) {
                if (!empty($element->type)) {
                    $prefix = 'price_block_type_' . (string)$element->type;
                    $cacheKeyInfo[$prefix . '_block'] = empty($element->block) ? '' : (string)$element->block;
                    $cacheKeyInfo[$prefix . '_template'] = empty($element->template) ? '' : (string)$element->template;
                }
            }
        }
        $cacheKeyInfo[] = $this->getPosition();
        if (!is_null($this->getItem())) {
            $cacheKeyInfo['item_id'] = $this->getItem()->getId();
        }
        return $cacheKeyInfo;
    }
}
