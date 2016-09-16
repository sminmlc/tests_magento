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
		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setTitle($this->__('Title here'));
		$this->renderLayout();
	}
}
?>