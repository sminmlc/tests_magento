<?php

/**
 * Webservices module
 *
 * PHP version 5
 *
 * @codepool Local
 * @category Sminmlc
 * @package Sminmlc_Webservices
 * @module Webservices
 * @copyright 2016 Sminmlc
 * @license GNU General Public License v3 <http://www.gnu.org/licenses/gpl-3.0.txt>
 * @version SVN:
 */
class Sminmlc_Webservices_Model_WebserviceCcf extends Mage_Core_Model_Abstract
{
    /**
     * Private method that returns proxy configuration for WS
     * 
     * @return array
     */
    private function _getProxy() 
    {
        $proxyArray = array();
        
        $proxyArray["host"] = Mage::getStoreConfig(
            'params/urls_params/host_proxy_dmz', 
            Mage::app()->getStore()
        );
        $proxyArray["port"] = Mage::getStoreConfig(
            'params/urls_params/port_proxy_dmz', 
            Mage::app()->getStore()
        );
        
        return $proxyArray;
    }
}
