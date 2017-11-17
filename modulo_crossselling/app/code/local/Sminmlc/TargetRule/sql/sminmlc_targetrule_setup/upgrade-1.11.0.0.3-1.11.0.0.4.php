<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

/* @var $installer Sminmlc_TargetRule_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_related'),
    $installer->getFkName(
        'sminmlc_targetrule/index_related',
        'customer_group_id',
        'customer/customer_group',
        'customer_group_id'
    )
);
$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_related'),
    $installer->getFkName(
        'sminmlc_targetrule/index_related',
        'entity_id',
        'catalog/product',
        'entity_id'
    )
);
$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_related'),
    $installer->getFkName(
        'sminmlc_targetrule/index_related',
        'store_id',
        'core/store',
        'store_id'
    )
);

$installer->getConnection()->dropIndex($installer->getTable('sminmlc_targetrule/index_related'), 'PRIMARY');

$installer->getConnection()
    ->addColumn($installer->getTable('sminmlc_targetrule/index_related'),
        'targetrule_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
            'comment' => 'Target Rule Id'
        )
    );

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/index_related'),
    $installer->getIdxName('sminmlc_targetrule/index_related',
        array(
            'entity_id',
            'store_id',
            'customer_group_id',
            'customer_segment_id'
        )
    ),
    array(
        'entity_id',
        'store_id',
        'customer_group_id',
        'customer_segment_id'
    ),
    Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/index_related',
        'customer_group_id',
        'customer/customer_group',
        'customer_group_id'
    ),
    $installer->getTable('sminmlc_targetrule/index_related'),
    'customer_group_id',
    $installer->getTable('customer/customer_group'),
    'customer_group_id'
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/index_related',
        'entity_id',
        'catalog/product',
        'entity_id'
    ),
    $installer->getTable('sminmlc_targetrule/index_related'),
    'entity_id',
    $installer->getTable('catalog/product'),
    'entity_id'
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/index_related',
        'store_id',
        'core/store',
        'store_id'
    ),
    $installer->getTable('sminmlc_targetrule/index_related'),
    'store_id',
    $installer->getTable('core/store'),
    'store_id'
);
$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/index_related'),
    $installer->getIdxName('sminmlc_targetrule/index_related', array('store_id')),
    array('store_id')
);

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/index_related'),
    $installer->getIdxName('sminmlc_targetrule/index_related', array('customer_group_id')),
    array('customer_group_id')
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    $installer->getFkName(
        'sminmlc_targetrule/index_upsell',
        'customer_group_id',
        'customer/customer_group',
        'customer_group_id'
    )
);
$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    $installer->getFkName(
        'sminmlc_targetrule/index_upsell',
        'entity_id',
        'catalog/product',
        'entity_id'
    )
);
$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    $installer->getFkName(
        'sminmlc_targetrule/index_upsell',
        'store_id',
        'core/store',
        'store_id'
    )
);

$installer->getConnection()->dropIndex($installer->getTable('sminmlc_targetrule/index_upsell'), 'PRIMARY');

$installer->getConnection()
    ->addColumn($installer->getTable('sminmlc_targetrule/index_upsell'),
    'targetrule_id',
    array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'comment' => 'Target Rule Id'
    )
);

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    $installer->getIdxName('sminmlc_targetrule/index_upsell',
        array(
            'entity_id',
            'store_id',
            'customer_group_id',
            'customer_segment_id'
        )
    ),
    array(
        'entity_id',
        'store_id',
        'customer_group_id',
        'customer_segment_id'
    ),
    Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/index_upsell',
        'customer_group_id',
        'customer/customer_group',
        'customer_group_id'
    ),
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    'customer_group_id',
    $installer->getTable('customer/customer_group'),
    'customer_group_id'
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/index_upsell',
        'entity_id',
        'catalog/product',
        'entity_id'
    ),
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    'entity_id',
    $installer->getTable('catalog/product'),
    'entity_id'
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/index_upsell',
        'store_id',
        'core/store',
        'store_id'
    ),
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    'store_id',
    $installer->getTable('core/store'),
    'store_id'
);
$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    $installer->getIdxName('sminmlc_targetrule/index_upsell', array('store_id')),
    array('store_id')
);

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    $installer->getIdxName('sminmlc_targetrule/index_upsell', array('customer_group_id')),
    array('customer_group_id')
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    $installer->getFkName(
        'sminmlc_targetrule/index_crosssell',
        'customer_group_id',
        'customer/customer_group',
        'customer_group_id'
    )
);
$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    $installer->getFkName(
        'sminmlc_targetrule/index_crosssell',
        'entity_id',
        'catalog/product',
        'entity_id'
    )
);
$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    $installer->getFkName(
        'sminmlc_targetrule/index_crosssell',
        'store_id',
        'core/store',
        'store_id'
    )
);

$installer->getConnection()->dropIndex($installer->getTable('sminmlc_targetrule/index_crosssell'), 'PRIMARY');

$installer->getConnection()
    ->addColumn($installer->getTable('sminmlc_targetrule/index_crosssell'),
    'targetrule_id',
    array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'comment' => 'Target Rule Id'
    )
);

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    $installer->getIdxName('sminmlc_targetrule/index_crosssell',
        array(
            'entity_id',
            'store_id',
            'customer_group_id',
            'customer_segment_id'
        )
    ),
    array(
        'entity_id',
        'store_id',
        'customer_group_id',
        'customer_segment_id'
    ),
    Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/index_crosssell',
        'customer_group_id',
        'customer/customer_group',
        'customer_group_id'
    ),
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    'customer_group_id',
    $installer->getTable('customer/customer_group'),
    'customer_group_id'
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/index_crosssell',
        'entity_id',
        'catalog/product',
        'entity_id'
    ),
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    'entity_id',
    $installer->getTable('catalog/product'),
    'entity_id'
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/index_crosssell',
        'store_id',
        'core/store',
        'store_id'
    ),
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    'store_id',
    $installer->getTable('core/store'),
    'store_id'
);

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    $installer->getIdxName('sminmlc_targetrule/index_crosssell', array('store_id')),
    array('store_id')
);

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    $installer->getIdxName('sminmlc_targetrule/index_crosssell', array('customer_group_id')),
    array('customer_group_id')
);

/**
 * Create table 'sminmlc_targetrule/index_related_product'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('sminmlc_targetrule/index_related_product'))
    ->addColumn('targetrule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
    ), 'TargetRule Id')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
    ), 'Product Id')
    ->addIndex($installer->getIdxName('sminmlc_targetrule/index_related_product', array('targetrule_id')),
        array('targetrule_id'))
    ->addIndex($installer->getIdxName('sminmlc_targetrule/index_related_product',
        array('targetrule_id', 'product_id'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('targetrule_id', 'product_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )
    ->addForeignKey(
        $installer->getFkName(
            'sminmlc_targetrule/index_related_product',
            'targetrule_id',
            'sminmlc_targetrule/index_related',
            'targetrule_id'
        ),
        'targetrule_id',
        $installer->getTable('sminmlc_targetrule/index_related'),
        'targetrule_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Sminmlc Targetrule Related Products');
$installer->getConnection()->createTable($table);
/**
 * Create table 'sminmlc_targetrule/index_upsell_product'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('sminmlc_targetrule/index_upsell_product'))
    ->addColumn('targetrule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
    ), 'TargetRule Id')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
    ), 'Product Id')
    ->addIndex($installer->getIdxName('sminmlc_targetrule/index_upsell_product', array('targetrule_id')),
        array('targetrule_id'))
    ->addIndex($installer->getIdxName('sminmlc_targetrule/index_upsell_product',
        array('targetrule_id', 'product_id'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('targetrule_id', 'product_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )
    ->addForeignKey(
        $installer->getFkName(
            'sminmlc_targetrule/index_upsell_product',
            'targetrule_id',
            'sminmlc_targetrule/index_upsell',
            'targetrule_id'
        ),
        'targetrule_id',
        $installer->getTable('sminmlc_targetrule/index_upsell'),
        'targetrule_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Sminmlc Targetrule Upsell Products');
$installer->getConnection()->createTable($table);
/**
 * Create table 'sminmlc_targetrule/index_crosssell_product'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('sminmlc_targetrule/index_crosssell_product'))
    ->addColumn('targetrule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
    ), 'TargetRule Id')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
    ), 'Product Id')
    ->addIndex($installer->getIdxName('sminmlc_targetrule/index_crosssell_product', array('targetrule_id')),
        array('targetrule_id'))
    ->addIndex($installer->getIdxName('sminmlc_targetrule/index_crosssell_product',
        array('targetrule_id', 'product_id'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('targetrule_id', 'product_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )
    ->addForeignKey(
        $installer->getFkName(
            'sminmlc_targetrule/index_crosssell_product',
            'targetrule_id',
            'sminmlc_targetrule/index_crosssell',
            'targetrule_id'
        ),
        'targetrule_id',
        $installer->getTable('sminmlc_targetrule/index_crosssell'),
        'targetrule_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Sminmlc Targetrule Crosssell Products');
$installer->getConnection()->createTable($table);

$installer->endSetup();
