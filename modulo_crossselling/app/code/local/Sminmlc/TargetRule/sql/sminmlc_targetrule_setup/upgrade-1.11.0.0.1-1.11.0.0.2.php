<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

/* @var $installer Sminmlc_TargetRule_Model_Resource_Setup */
$installer = $this;
$connection = $installer->getConnection();

$installer->startSetup();

$connection->modifyColumn(
        $installer->getTable('sminmlc_targetrule/rule'),
        'use_customer_segment',
        array(
            'type'     => Varien_Db_Ddl_Table::TYPE_SMALLINT,
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
            'comment'  => 'Deprecated after 1.11.2.0'
        )
);

$connection->modifyColumn(
        $installer->getTable('sminmlc_targetrule/product'),
        'store_id',
        array(
            'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
            'comment'   => 'Deprecated after 1.11.2.0'
        )
);

$installer->endSetup();
