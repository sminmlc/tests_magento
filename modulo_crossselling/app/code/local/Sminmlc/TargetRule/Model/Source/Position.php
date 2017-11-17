<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

class Sminmlc_TargetRule_Model_Source_Position
{

    /**
     * Get data for Position behavior selector
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            Sminmlc_TargetRule_Model_Rule::BOTH_SELECTED_AND_RULE_BASED =>
                Mage::helper('sminmlc_targetrule')->__('Both Selected and Rule-Based'),
            Sminmlc_TargetRule_Model_Rule::SELECTED_ONLY =>
                Mage::helper('sminmlc_targetrule')->__('Selected Only'),
            Sminmlc_TargetRule_Model_Rule::RULE_BASED_ONLY =>
                Mage::helper('sminmlc_targetrule')->__('Rule-Based Only'),
        );
    }

}
