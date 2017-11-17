<?php

/**
 * Class Sminmlc_Validation_Model_Validation
 * @author Marc López <m.1991.lp@gmail.com>
 */
class Sminmlc_Validation_Model_Validation extends Mage_Core_Model_Abstract
{
    protected function _construct() {
        $this->_init('sminmlc_validation/validation');
    }

    /**
     * @param $string
     * @return string without accents
     * ex: Mage::getModel('sminmlc_validation/validation')->removeAccents("hóòlàá smin test accents")
     */
    public function removeAccents($string)
    {
        return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'))), ' '));
    }
}
