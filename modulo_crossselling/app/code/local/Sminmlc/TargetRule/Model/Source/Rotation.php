<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

class Sminmlc_TargetRule_Model_Source_Rotation
{

    /**
     * Get data for Rotation mode selector
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            Sminmlc_TargetRule_Model_Rule::ROTATION_NONE =>
                Mage::helper('sminmlc_targetrule')->__('Do not rotate'),
            Sminmlc_TargetRule_Model_Rule::ROTATION_SHUFFLE =>
                Mage::helper('sminmlc_targetrule')->__('Shuffle'),
        );
    }

}
