<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

/* @var $installer Sminmlc_TargetRule_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn(
    $installer->getTable('sminmlc_targetrule/index'),
    'customer_segment_id',
    array(
        'type'     => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'nullable' => false,
        'default'  => '0',
        'comment'  => 'Customer Segment Id'
    )
);

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/index'),
    $installer->getConnection()->getPrimaryKeyName($installer->getTable('sminmlc_targetrule/index')),
    array(
        'entity_id',
        'store_id',
        'customer_group_id',
        'type_id',
        'customer_segment_id'
    ),
    Varien_Db_Adapter_Interface::INDEX_TYPE_PRIMARY
);

$installer->getConnection()->addColumn(
    $installer->getTable('sminmlc_targetrule/index_related'),
    'customer_segment_id',
    array(
        'type'     => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
        'comment'  => 'Customer Segment Id'
    )
);
$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/index_related'),
    $installer->getConnection()->getPrimaryKeyName($installer->getTable('sminmlc_targetrule/index_related')),
    array(
        'entity_id',
        'store_id',
        'customer_group_id',
        'customer_segment_id'
    ),
    Varien_Db_Adapter_Interface::INDEX_TYPE_PRIMARY
);

$installer->getConnection()->addColumn(
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    'customer_segment_id',
    array(
        'type'     => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
        'comment'  => 'Customer Segment Id'
    )
);
$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    $installer->getConnection()->getPrimaryKeyName($installer->getTable('sminmlc_targetrule/index_upsell')),
    array(
        'entity_id',
        'store_id',
        'customer_group_id',
        'customer_segment_id'
    ),
    Varien_Db_Adapter_Interface::INDEX_TYPE_PRIMARY
);

$installer->getConnection()->addColumn(
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    'customer_segment_id',
    array(
        'type'     => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
        'comment'  => 'Customer Segment Id'
    )
);
$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    $installer->getConnection()->getPrimaryKeyName($installer->getTable('sminmlc_targetrule/index_crosssell')),
    array(
        'entity_id',
        'store_id',
        'customer_group_id',
        'customer_segment_id'
    ),
    Varien_Db_Adapter_Interface::INDEX_TYPE_PRIMARY
);

$installer->endSetup();
