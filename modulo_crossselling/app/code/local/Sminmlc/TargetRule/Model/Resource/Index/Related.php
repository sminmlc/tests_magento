<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */


/**
 * TargetRule Related Catalog Product List Index Resource Model
 *
 * @category    Sminmlc
 * @package     Sminmlc_TargetRule
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sminmlc_TargetRule_Model_Resource_Index_Related extends Sminmlc_TargetRule_Model_Resource_Index_Abstract
{
    /**
     * Product List Type identifier
     *
     * @var int
     */
    protected $_listType     = Sminmlc_TargetRule_Model_Rule::RELATED_PRODUCTS;

    /**
     * Initialize connection and define main table
     *
     */
    protected function _construct()
    {
        $this->_init('sminmlc_targetrule/index_related', 'targetrule_id');
    }
}
