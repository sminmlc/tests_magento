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
class Sminmlc_Tickets_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction(){
		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setTitle($this->__('Title here'));
		$this->renderLayout();
	}
}
?>
