<?php
/**
 * Tickets module
 *
 * PHP version 5
 *
 * @codepool Local
 * @category Sminmlc
 * @package Sminmlc_Tickets
 * @module Tickets
 * @copyright 2016 Sminmlc
 * @license GNU General Public License v3 <http://www.gnu.org/licenses/gpl-3.0.txt>
 * @version SVN:
 */
class Sminmlc_Tickets_Block_Tickets extends Mage_Core_Block_Template
{
	function misPedidos(){
		$usuario = $this->usuario();
		$email = $usuario->getEmail();
		$orderCollection = Mage::getModel('sales/order')->getCollection();
		$orderCollection->addFieldToFilter('customer_email', $email);
		$html = '<select name="order_id" id="order_id" class="select-box-gi validation-passed">';
		$html .= '<option value="">-- Selecciona un pedido --</option>';
		foreach ($orderCollection as $_order)
		{
			$html .= '<option value="'.$_order->getIncrementId().'">#'.$_order->getIncrementId().' del '.$this->formatDate($_order->getCreatedAtStoreDate()).' ('.$_order->formatPrice($_order->getGrandTotal()).') - '.$_order->getStatusLabel().'</option>';
		}
		$html .= '</select>';
		print $html;
	}
	function usuario(){
		return Mage::getSingleton('customer/session')->getCustomer();
	}
}
