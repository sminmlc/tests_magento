<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */


/**
 * TargetRule Catalog Product List Related Block
 *
 * @category   Sminmlc
 * @package    Sminmlc_TargetRule
 */
class Sminmlc_TargetRule_Block_Catalog_Product_List_Related
    extends Sminmlc_TargetRule_Block_Catalog_Product_List_Abstract
{
    /**
     * Default MAP renderer type
     *
     * @var string
     */
    protected $_mapRenderer = 'msrp_noform';

    /**
     * Retrieve Catalog Product List Type identifier
     *
     * @return int
     */
    public function getProductListType()
    {
        return Sminmlc_TargetRule_Model_Rule::RELATED_PRODUCTS;
    }

    /**
     * Retrieve array of exclude product ids
     * Rewrite for exclude shopping cart products
     *
     * @return array
     */
    public function getExcludeProductIds()
    {
        if (is_null($this->_excludeProductIds)) {
            $cartProductIds = Mage::getSingleton('checkout/cart')->getProductIds();
            $this->_excludeProductIds = array_merge($cartProductIds, array($this->getProduct()->getEntityId()));
        }
        return $this->_excludeProductIds;
    }
}
