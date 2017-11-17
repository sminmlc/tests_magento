<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

/**
 * TargetRule Crosssell Catalog Product List Index Resource Model
 *
 * @category    Sminmlc
 * @package     Sminmlc_TargetRule
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sminmlc_TargetRule_Model_Resource_Index_Crosssell extends Sminmlc_TargetRule_Model_Resource_Index_Abstract
{
    /**
     * Product List Type identifier
     *
     * @var int
     */
    protected $_listType     = Sminmlc_TargetRule_Model_Rule::CROSS_SELLS;

    /**
     * Initialize connection and define main table
     *
     */
    protected function _construct()
    {
        $this->_init('sminmlc_targetrule/index_crosssell', 'targetrule_id');
    }
}
