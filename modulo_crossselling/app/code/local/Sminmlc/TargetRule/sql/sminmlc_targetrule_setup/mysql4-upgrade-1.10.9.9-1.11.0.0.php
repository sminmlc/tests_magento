<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

/* @var $installer Sminmlc_TargetRule_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/**
 * Drop foreign keys
 */
$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/customersegment'),
    'FK_ENTERPRISE_TARGETRULE_CUSTOMERSEGMENT_RULE'
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/customersegment'),
    'FK_ENTERPRISE_TARGETRULE_CUSTOMERSEGMENT_SEGMENT'
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index'),
    'FK_ENTERPRISE_TARGETRULE_INDEX_PRODUCT'
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index'),
    'FK_ENTERPRISE_TARGETRULE_INDEX_STORE'
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    'FK_ENTERPRISE_TARGETRULE_INDEX_CROSSSELL_CUSTOMER_GROUP'
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    'FK_ENTERPRISE_TARGETRULE_INDEX_CROSSSELL_PRODUCT'
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    'FK_ENTERPRISE_TARGETRULE_INDEX_CROSSSELL_STORE'
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_related'),
    'FK_ENTERPRISE_TARGETRULE_INDEX_RELATED_CUSTOMER_GROUP'
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_related'),
    'FK_ENTERPRISE_TARGETRULE_INDEX_RELATED_PRODUCT'
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_related'),
    'FK_ENTERPRISE_TARGETRULE_INDEX_RELATED_STORE'
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index'),
    'FK_ENTERPRISE_TARGETRULE_INDEX_CUSTOMER_GROUP'
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    'FK_ENTERPRISE_TARGETRULE_INDEX_UPSELL_CUSTOMER_GROUP'
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    'FK_ENTERPRISE_TARGETRULE_INDEX_UPSELL_PRODUCT'
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    'FK_ENTERPRISE_TARGETRULE_INDEX_UPSELL_STORE'
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/product'),
    'FK_ENTERPRISE_TARGETRULE_PRODUCT_PRODUCT'
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/product'),
    'FK_ENTERPRISE_TARGETRULE_PRODUCT_RULE'
);

$installer->getConnection()->dropForeignKey(
    $installer->getTable('sminmlc_targetrule/product'),
    'FK_ENTERPRISE_TARGETRULE_PRODUCT_STORE'
);


/**
 * Drop indexes
 */
$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/rule'),
    'IDX_IS_ACTIVE'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/rule'),
    'IDX_APPLY_TO'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/rule'),
    'IDX_SORT_ORDER'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/rule'),
    'IDX_USE_CUSTOMER_SEGMENT'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/rule'),
    'IDX_DATE'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/index'),
    'IDX_STORE'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/index'),
    'IDX_CUSTOMER_GROUP'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/index'),
    'IDX_TYPE'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    'IDX_STORE'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    'IDX_CUSTOMER_GROUP'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/customersegment'),
    'IDX_SEGMENT'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/index_related'),
    'IDX_STORE'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/index_related'),
    'IDX_CUSTOMER_GROUP'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    'IDX_STORE'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    'IDX_CUSTOMER_GROUP'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/product'),
    'IDX_PRODUCT'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sminmlc_targetrule/product'),
    'IDX_STORE'
);


/*
 * Change columns
 */
$tables = array(
    $installer->getTable('sminmlc_targetrule/rule') => array(
        'columns' => array(
            'rule_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
                'identity'  => true,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Rule Id'
            ),
            'name' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
                'length'    => 255,
                'comment'   => 'Name'
            ),
            'from_date' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_DATE,
                'comment'   => 'From Date'
            ),
            'to_date' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_DATE,
                'comment'   => 'To Date'
            ),
            'is_active' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'nullable'  => false,
                'default'   => '0',
                'comment'   => 'Is Active'
            ),
            'conditions_serialized' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
                'length'    => '64K',
                'nullable'  => false,
                'comment'   => 'Conditions Serialized'
            ),
            'actions_serialized' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
                'length'    => '64K',
                'nullable'  => false,
                'comment'   => 'Actions Serialized'
            ),
            'positions_limit' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
                'nullable'  => false,
                'default'   => '0',
                'comment'   => 'Positions Limit'
            ),
            'apply_to' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'unsigned'  => true,
                'nullable'  => false,
                'comment'   => 'Apply To'
            ),
            'sort_order' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
                'comment'   => 'Sort Order'
            ),
            'use_customer_segment' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
                'comment'   => 'Use Customer Segment'
            ),
            'action_select' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
                'length'    => '64K',
                'comment'   => 'Action Select'
            ),
            'action_select_bind' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
                'length'    => '64K',
                'comment'   => 'Action Select Bind'
            )
        ),
        'comment' => 'Sminmlc Targetrule'
    ),
    $installer->getTable('sminmlc_targetrule/customersegment') => array(
        'columns' => array(
            'rule_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Rule Id'
            ),
            'segment_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Segment Id'
            )
        ),
        'comment' => 'Sminmlc Targetrule Customersegment'
    ),
    $installer->getTable('sminmlc_targetrule/product') => array(
        'columns' => array(
            'rule_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Rule Id'
            ),
            'product_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Product Id'
            ),
            'store_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Store Id'
            )
        ),
        'comment' => 'Sminmlc Targetrule Product'
    ),
    $installer->getTable('sminmlc_targetrule/index') => array(
        'columns' => array(
            'entity_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Entity Id'
            ),
            'store_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Store Id'
            ),
            'customer_group_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Customer Group Id'
            ),
            'type_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Type Id'
            ),
            'flag' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '1',
                'comment'   => 'Flag'
            )
        ),
        'comment' => 'Sminmlc Targetrule Index'
    ),
    $installer->getTable('sminmlc_targetrule/index_related') => array(
        'columns' => array(
            'entity_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Entity Id'
            ),
            'store_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Store Id'
            ),
            'customer_group_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Customer Group Id'
            )
        ),
        'comment' => 'Sminmlc Targetrule Index Related'
    ),
    $installer->getTable('sminmlc_targetrule/index_crosssell') => array(
        'columns' => array(
            'entity_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Entity Id'
            ),
            'store_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Store Id'
            ),
            'customer_group_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Customer Group Id'
            )
        ),
        'comment' => 'Sminmlc Targetrule Index Crosssell'
    ),
    $installer->getTable('sminmlc_targetrule/index_upsell') => array(
        'columns' => array(
            'entity_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Entity Id'
            ),
            'store_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Store Id'
            ),
            'customer_group_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Customer Group Id'
            )
        ),
        'comment' => 'Sminmlc Targetrule Index Upsell'
    )
);

$installer->getConnection()->modifyTables($tables);

$installer->getConnection()->dropColumn(
    $installer->getTable('catalog/eav_attribute'),
    'is_used_for_target_rules'
);

$installer->getConnection()->changeColumn(
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    'value',
    'product_ids',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => 255,
        'comment'   => 'CrossSell Product Ids'
    )
);

$installer->getConnection()->changeColumn(
    $installer->getTable('sminmlc_targetrule/index_related'),
    'value',
    'product_ids',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => 255,
        'comment'   => 'Related Product Ids'
    )
);

$installer->getConnection()->changeColumn(
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    'value',
    'product_ids',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => 255,
        'comment'   => 'Upsell Product Ids'
    )
);


/**
 * Add indexes
 */
$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/rule'),
    $installer->getIdxName('sminmlc_targetrule/rule', array('is_active')),
    array('is_active')
);

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/rule'),
    $installer->getIdxName('sminmlc_targetrule/rule', array('apply_to')),
    array('apply_to')
);

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/rule'),
    $installer->getIdxName('sminmlc_targetrule/rule', array('sort_order')),
    array('sort_order')
);

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/rule'),
    $installer->getIdxName('sminmlc_targetrule/rule', array('use_customer_segment')),
    array('use_customer_segment')
);

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/rule'),
    $installer->getIdxName('sminmlc_targetrule/rule', array('from_date', 'to_date')),
    array('from_date', 'to_date')
);

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/customersegment'),
    $installer->getIdxName('sminmlc_targetrule/customersegment', array('segment_id')),
    array('segment_id')
);

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/index'),
    $installer->getIdxName('sminmlc_targetrule/index', array('store_id')),
    array('store_id')
);

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/index'),
    $installer->getIdxName('sminmlc_targetrule/index', array('customer_group_id')),
    array('customer_group_id')
);

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/index'),
    $installer->getIdxName('sminmlc_targetrule/index', array('type_id')),
    array('type_id')
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

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/product'),
    $installer->getIdxName('sminmlc_targetrule/product', array('product_id')),
    array('product_id')
);

$installer->getConnection()->addIndex(
    $installer->getTable('sminmlc_targetrule/product'),
    $installer->getIdxName('sminmlc_targetrule/product', array('store_id')),
    array('store_id')
);


/**
 * Add foreign keys
 */
$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/customersegment',
        'rule_id',
        'sminmlc_targetrule/rule',
        'rule_id'
    ),
    $installer->getTable('sminmlc_targetrule/customersegment'),
    'rule_id',
    $installer->getTable('sminmlc_targetrule/rule'),
    'rule_id'
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/customersegment',
        'segment_id',
        'sminmlc_customersegment/segment',
        'segment_id'
    ),
    $installer->getTable('sminmlc_targetrule/customersegment'),
    'segment_id',
    $installer->getTable('sminmlc_customersegment/segment'),
    'segment_id'
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/index',
        'customer_group_id',
        'customer/customer_group',
        'customer_group_id'
    ),
    $installer->getTable('sminmlc_targetrule/index'),
    'customer_group_id',
    $installer->getTable('customer/customer_group'),
    'customer_group_id'
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/index',
        'entity_id',
        'catalog/product',
        'entity_id'
    ),
    $installer->getTable('sminmlc_targetrule/index'),
    'entity_id',
    $installer->getTable('catalog/product'),
    'entity_id'
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/index',
        'store_id',
        'core/store',
        'store_id'
    ),
    $installer->getTable('sminmlc_targetrule/index'),
    'store_id',
    $installer->getTable('core/store'),
    'store_id'
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

$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/product',
        'store_id',
        'core/store',
        'store_id'
    ),
    $installer->getTable('sminmlc_targetrule/product'),
    'store_id',
    $installer->getTable('core/store'),
    'store_id'
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/product',
        'product_id',
        'catalog/product',
        'entity_id'
    ),
    $installer->getTable('sminmlc_targetrule/product'),
    'product_id',
    $installer->getTable('catalog/product'),
    'entity_id'
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName(
        'sminmlc_targetrule/product',
        'rule_id',
        'sminmlc_targetrule/rule',
        'rule_id'
    ),
    $installer->getTable('sminmlc_targetrule/product'),
    'rule_id',
    $installer->getTable('sminmlc_targetrule/rule'),
    'rule_id'
);

$installer->endSetup();
