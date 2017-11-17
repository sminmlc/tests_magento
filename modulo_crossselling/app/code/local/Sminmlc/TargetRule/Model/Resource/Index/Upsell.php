<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */


/**
 * TargetRule Upsell Catalog Product List Index Resource Model
 *
 * @category    Sminmlc
 * @package     Sminmlc_TargetRule
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sminmlc_TargetRule_Model_Resource_Index_Upsell extends Sminmlc_TargetRule_Model_Resource_Index_Abstract
{
    /**
     * Product List Type identifier
     *
     * @var int
     */
    protected $_listType     = Sminmlc_TargetRule_Model_Rule::UP_SELLS;

    /**
     * Initialize connection and define main table
     *
     */
    protected function _construct()
    {
        $this->_init('sminmlc_targetrule/index_upsell', 'targetrule_id');
    }
}
