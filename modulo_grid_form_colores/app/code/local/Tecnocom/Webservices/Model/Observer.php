<?php
/**
 * Webservices module
 *
 * PHP version 5
 *
 * @codepool Local
 * @category Tecnocom
 * @package Tecnocom_Webservices
 * @module Webservices
 * @copyright 2016 Tecnocom/Aether
 * @license GNU General Public License v3 <http://www.gnu.org/licenses/gpl-3.0.txt>
 * @version SVN:
 */
class Tecnocom_Webservices_Model_Observer extends Varien_Event_Observer
{
    /**
     * Exports an Order to WS CCF after it is placed
     *
     * @param Varien_Event_Observer $observer observer object
     *
     * @return boolean
     */
    public function exportOrderCcf(Varien_Event_Observer $observer)
    {
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_Observer-->exportOrderCcf($order) [START]');
        }
        
        $order = $observer->getEvent()->getOrder();
        $orderExported = false;
        
        if (empty($order)) {
            Mage::throwException(
                Mage::helper('tecnocom_webservices')->__(
                    '(EMPTY) Error exporting Order. The Order is cancelled. Please try again later.'
                )
            );
        } else {
            $response = Mage::getModel('tecnocom_webservices/webserviceCcf')->ccfAlta($order);
            if (!empty($response)) {
                if (in_array($response->return->codRespuesta, array('OK', 'OK_000', 'OK_001'))) {
                    $orderExported = true;
                }
            }
        }
        
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_Observer-->exportOrderCcf($order) [END]');
        }
        
        return $orderExported;
    }
    
    /**
     * Updates an Order to WS CCF after it is saved and paid
     *
     * @param Varien_Event_Observer $observer observer object
     *
     * @return boolean
     */
    private function _updateOrderCcf(Varien_Event_Observer $observer)
    {
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_Observer-->_updateOrderCcf($observer) [START]');
        }

        $orderId = $observer->getEvent()->getOrderIds();
        $order = Mage::getSingleton('sales/order')->load($orderId);
        $orderUpdated = false;
        
        if (empty($order)) {
            Mage::getSingleton('checkout/session')->addError(
                Mage::helper('tecnocom_webservices')->__(
                    'Error updating Order: Empty.'
                )
            );
        } else {
            $orderState = $order->getState();
            $orderStatus = $order->getStatus();

            if (Mage::getIsDeveloperMode()) {
                Mage::log('Tecnocom_Webservices_Model_Observer-->_updateOrderCcf($observer) - $orderState = ');
                Mage::log(var_export($orderState, true));
                Mage::log('Tecnocom_Webservices_Model_Observer-->_updateOrderCcf($observer) - $orderStatus = ');
                Mage::log(var_export($orderStatus, true));
            }

            //state = processing & status = *_paid
            if (($orderState == Mage_Sales_Model_Order::STATE_PROCESSING) && preg_match('/_paid$/', $orderStatus)) {
                $status = '3';
            //state = pending_payment & status = card_payment
            } else if (($orderState == Mage_Sales_Model_Order::STATE_PENDING_PAYMENT) && preg_match('/card_payment$/', $orderStatus)) {
                $status = '1';
            //state = canceled & status = canceled
            } else if (($orderState == Mage_Sales_Model_Order::STATE_CANCELED) && preg_match('/canceled$/', $orderStatus)) {
                $status = '10';
            //Others
            } else {
                $status = '1';
            }

            if (Mage::getIsDeveloperMode()) {
                Mage::log('Tecnocom_Webservices_Model_Observer-->_updateOrderCcf($observer) - $status = ');
                Mage::log(var_export($status, true));
            }

            $response = Mage::getModel('tecnocom_webservices/webserviceCcf')->ccfActualiza($order, $status);
            if (!empty($response)) {
                if (in_array($response->return->codRespuesta, array('OK', 'OK_000', 'OK_001'))) {
                    //ccfActualiza --> OK
                    $orderUpdated = true;
                }
            }
        }
        
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_Observer-->_updateOrderCcf($observer) [END]');
        }
        
        return $orderUpdated;
    }
    
    /**
     * Updates an Order to WS CCF after succeed paid
     *
     * @param Varien_Event_Observer $observer observer object
     *
     * @return boolean
     */
    public function updateOrderSuccessCcf(Varien_Event_Observer $observer)
    {
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_Observer-->updateOrderSuccessCcf($observer) [START]');
            $event = $observer->getEvent();
            Mage::log('Tecnocom_Webservices_Model_Observer-->updateOrderSuccessCcf($observer) - dispatchEvent = ');
            Mage::log(var_export($event->getName(), true));
        }
        
        $return = $this->_updateOrderCcf($observer);
        
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_Observer-->updateOrderSuccessCcf($observer) [END]');
        }
        
        return $return;
    }
        
    /**
     * Updates an Order to WS CCF after failed paid
     *
     * @param Varien_Event_Observer $observer observer object
     *
     * @return boolean
     */
    public function updateOrderFailureCcf(Varien_Event_Observer $observer)
    {
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_Observer-->updateOrderFailureCcf($observer) [START]');
            $event = $observer->getEvent();
            Mage::log('Tecnocom_Webservices_Model_Observer-->updateOrderFailureCcf($observer) - dispatchEvent = ');
            Mage::log(var_export($event->getName(), true));
        }
        
        $return = $this->_updateOrderCcf($observer);
        
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_Observer-->updateOrderFailureCcf($observer) [END]');
        }
        
        return $return;
    }
    
    /**
     * Export webservice log
     * 
     * @param Varien_Event_Observer $observer
     */
    public function exportarWebserviceLog($observer) 
    {
        $storeId= Mage::app()->getStore()->getStoreId();
        $emailTemplate = Mage::getModel('core/email_template')->load(26);
        $emailTemplateVariables = array();
        $emailTemplateVariables['date'] = date('Y-m-d h:i:s');
        
        //Coger datos para el subject del email transaccional
        $urgentes = 0;
        $medios = 0;
        $leves = 0;
        $model = Mage::getModel('tecnocom_webservices/webservices');
        $collection = $model->getCollection()->addFieldToFilter(
            'date', 
            array(
                'from' => date('Y-m-d h:i:s', strtotime('-1 day')), 
                'to' => date('Y-m-d h:i:s')
            )
        );
        
        foreach($collection as $item) {
            if ($item->getPriority() == 'urgente') {
                $urgentes = $urgentes + 1;
            } else if ($item->getPriority() == 'medio') {
                $medios = $medios + 1;
            } else {
                $leves = $leves + 1;
            }
        }
        
        $pedidos = Mage::getModel('sales/order')->getCollection()->addAttributeToFilter(
            'created_at', 
            array(
                'from'=> date('Y-m-d h:i:s', strtotime('-1 day')), 
                'to'=> date('Y-m-d h:i:s')
            )
        )->getSize();
        //FIN coger datos
        
        $emailTemplateVariables['urgentes'] = $urgentes;
        $emailTemplateVariables['medios'] = $medios;
        $emailTemplateVariables['leves'] = $leves;
        $emailTemplateVariables['pedidos'] = $pedidos;
        
        $emailTemplate->getProcessedTemplate($emailTemplateVariables);
        $emailTemplate->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email', $storeId));
        $emailTemplate->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name', $storeId));
        
        try {
            $emailTemplate->send('marc.lopezc@tecnocom.es','Marc López Cobero', $emailTemplateVariables);
            $emailTemplate->send('support@aetherconsulting.net','Aether Consulting', $emailTemplateVariables);
            Mage::Log("Email enviado correctamente");
        } catch (Exception $e) {
            Mage::Log("ERROR al enviar email ".$e);
        }
    }
}
