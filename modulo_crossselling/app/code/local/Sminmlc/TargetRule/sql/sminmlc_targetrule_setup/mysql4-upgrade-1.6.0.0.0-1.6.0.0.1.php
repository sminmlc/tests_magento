<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */


/* @var $installer Sminmlc_TargetRule_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();
$installer->getConnection()->addColumn($installer->getTable('sminmlc_targetrule/rule'), 'action_select',
    'BLOB DEFAULT NULL');
$installer->getConnection()->addColumn($installer->getTable('sminmlc_targetrule/rule'), 'action_select_bind',
    'BLOB DEFAULT NULL');
$installer->endSetup();
