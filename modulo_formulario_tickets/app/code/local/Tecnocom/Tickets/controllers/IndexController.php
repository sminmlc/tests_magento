<?php
/**
 * Tickets module
 *
 * PHP version 5
 *
 * @codepool Local
 * @category Tecnocom
 * @package Tecnocom_Tickets
 * @module Tickets
 * @copyright 2016 Tecnocom/Aether
 * @license GNU General Public License v3 <http://www.gnu.org/licenses/gpl-3.0.txt>
 * @version SVN:
 */
class Tecnocom_Tickets_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction(){
		if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
			$this->_redirect('customer/account/login');
    	}
		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setTitle($this->__('Tickets'));
		$this->renderLayout();
	}
	public function sendAction(){
		$params = $this->getRequest()->getParams();
		$storeId= Mage::app()->getStore()->getStoreId();
        $emailTemplate = Mage::getModel('core/email_template')->load(27);
        $emailTemplateVariables = array();
		$emailTemplateVariables['customer'] = $params['customer'];
		$emailTemplateVariables['order_id'] = $params['order_id'];
		$emailTemplateVariables['incidencia_type'] = $params['incidencia_type'];
		$emailTemplateVariables['comentario'] = $params['comentario'];
		
        $emailTemplate->getProcessedTemplate($emailTemplateVariables);
        $emailTemplate->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email', $storeId));
        $emailTemplate->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name', $storeId));
		
        try {
            $emailTemplate->send('marc.lopezc@tecnocom.es','Marc López Cobero', $emailTemplateVariables);
            $emailTemplate->send('support@aetherconsulting.net','Aether Consulting', $emailTemplateVariables);
			Mage::getSingleton('core/session')->addSuccess('Ticket enviado correctamente.');
        }        
        catch(Exception $ex) {
            Mage::getSingleton('core/session')->addError('No se ha podido enviar el ticket, prueba más tarde.');
        }
 
        //Redirect back to index action of (this) inchoo-simplecontact controller
        $this->_redirect('tickets/');
	}
}
?>