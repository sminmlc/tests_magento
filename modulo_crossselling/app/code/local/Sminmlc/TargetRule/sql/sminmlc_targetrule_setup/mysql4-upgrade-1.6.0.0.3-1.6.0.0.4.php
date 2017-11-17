<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

/** @var Sminmlc_TargetRule_Model_Mysql4_Setup */
$installer = $this;

/** @var Varien_Db_Adapter_Pdo_Mysql */
$connection = $installer->getConnection();

$connection->truncate($installer->getTable('sminmlc_targetrule/index'));
$connection->truncate($installer->getTable('sminmlc_targetrule/index_related'));
$connection->truncate($installer->getTable('sminmlc_targetrule/index_crosssell'));
$connection->truncate($installer->getTable('sminmlc_targetrule/index_upsell'));
