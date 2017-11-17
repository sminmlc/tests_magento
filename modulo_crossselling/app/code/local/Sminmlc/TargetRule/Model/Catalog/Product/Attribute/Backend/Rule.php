<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */


/**
 * TargetRule Catalog Product Attributes Backend Model
 *
 * @category   Sminmlc
 * @package    Sminmlc_TargetRule
 */
class Sminmlc_TargetRule_Model_Catalog_Product_Attribute_Backend_Rule
    extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{
    /**
     * Before attribute save prepare data
     *
     * @param Mage_Catalog_Model_Product $object
     * @return Sminmlc_TargetRule_Model_Catalog_Product_Attribute_Backend_Rule
     */
    public function beforeSave($object)
    {
        $attributeName  = $this->getAttribute()->getName();
        $useDefault     = $object->getData($attributeName . '_default');

        if ($useDefault == 1) {
            $object->setData($attributeName, null);
        }

        return $this;
    }
}
