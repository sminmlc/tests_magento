<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

/* @var $installer Sminmlc_TargetRule_Model_Resource_Setup */

$installer = $this;
$installer->startSetup();

// add config attributes to catalog product
$installer->addAttribute('catalog_product', 'related_tgtr_position_limit', array(
    'group'        => 'General',
    'label'        => Mage::helper('sminmlc_targetrule')->__('Related Target Rule Rule Based Positions'),
    'visible'      => false,
    'user_defined' => false,
    'required'     => false,
    'type'         => 'int',
    'global'       => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'input'        => 'text',
    'backend'      => 'sminmlc_targetrule/catalog_product_attribute_backend_rule',
));

$installer->addAttribute('catalog_product', 'related_tgtr_position_behavior', array(
    'group'        => 'General',
    'label'        => Mage::helper('sminmlc_targetrule')->__('Related Target Rule Position Behavior'),
    'visible'      => false,
    'user_defined' => false,
    'required'     => false,
    'type'         => 'int',
    'global'       => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'input'        => 'text',
    'backend'      => 'sminmlc_targetrule/catalog_product_attribute_backend_rule',
));

$installer->addAttribute('catalog_product', 'upsell_tgtr_position_limit', array(
    'group'        => 'General',
    'label'        => Mage::helper('sminmlc_targetrule')->__('Upsell Target Rule Rule Based Positions'),
    'visible'      => false,
    'user_defined' => false,
    'required'     => false,
    'type'         => 'int',
    'global'       => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'input'        => 'text',
    'backend'      =>'sminmlc_targetrule/catalog_product_attribute_backend_rule',
));

$installer->addAttribute('catalog_product', 'upsell_tgtr_position_behavior', array(
    'group'        => 'General',
    'label'        => Mage::helper('sminmlc_targetrule')->__('Upsell Target Rule Position Behavior'),
    'visible'      => false,
    'user_defined' => false,
    'required'     => false,
    'type'         => 'int',
    'global'       => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'input'        => 'text',
    'backend'      =>'sminmlc_targetrule/catalog_product_attribute_backend_rule',
));

/**
 * Create table 'sminmlc_targetrule/rule'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('sminmlc_targetrule/rule'))
    ->addColumn('rule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Rule Id')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Name')
    ->addColumn('from_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
        ), 'From Date')
    ->addColumn('to_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
        ), 'To Date')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '0',
        ), 'Is Active')
    ->addColumn('conditions_serialized', Varien_Db_Ddl_Table::TYPE_TEXT, '64K', array(
        'nullable'  => false,
        ), 'Conditions Serialized')
    ->addColumn('actions_serialized', Varien_Db_Ddl_Table::TYPE_TEXT, '64K', array(
        'nullable'  => false,
        ), 'Actions Serialized')
    ->addColumn('positions_limit', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default'   => '0',
        ), 'Positions Limit')
    ->addColumn('apply_to', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'Apply To')
    ->addColumn('sort_order', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        ), 'Sort Order')
    ->addColumn('use_customer_segment', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Use Customer Segment')
    ->addColumn('action_select', Varien_Db_Ddl_Table::TYPE_TEXT, '64K', array(
        ), 'Action Select')
    ->addColumn('action_select_bind', Varien_Db_Ddl_Table::TYPE_TEXT, '64K', array(
        ), 'Action Select Bind')
    ->addIndex($installer->getIdxName('sminmlc_targetrule/rule', array('is_active')),
        array('is_active'))
    ->addIndex($installer->getIdxName('sminmlc_targetrule/rule', array('apply_to')),
        array('apply_to'))
    ->addIndex($installer->getIdxName('sminmlc_targetrule/rule', array('sort_order')),
        array('sort_order'))
    ->addIndex($installer->getIdxName('sminmlc_targetrule/rule', array('use_customer_segment')),
        array('use_customer_segment'))
    ->addIndex($installer->getIdxName('sminmlc_targetrule/rule', array('from_date', 'to_date')),
        array('from_date', 'to_date'))
    ->setComment('Sminmlc Targetrule');
$installer->getConnection()->createTable($table);


/**
 * Create table 'sminmlc_targetrule/customersegment'
 */
$installer->run("
CREATE TABLE IF NOT EXISTS `sminmlc_targetrule_customersegment` (
  `rule_id` int(10) unsigned NOT NULL COMMENT 'Rule Id',
  `segment_id` int(10) unsigned NOT NULL COMMENT 'Segment Id',
  PRIMARY KEY (`rule_id`,`segment_id`),
  KEY `IDX_ENTERPRISE_TARGETRULE_CUSTOMERSEGMENT_SEGMENT_ID` (`segment_id`),
  CONSTRAINT `FK_3F24241CB17AA24EC0461050E89576BE` FOREIGN KEY (`segment_id`) REFERENCES `sminmlc_customersegment_segment` (`segment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ENT_TARGETRULE_CSTRSEGMENT_RULE_ID_ENT_TARGETRULE_RULE_ID` FOREIGN KEY (`rule_id`) REFERENCES `sminmlc_targetrule` (`rule_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Enterprise Targetrule Customersegment';
");


/**
 * Create table 'sminmlc_targetrule/product'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('sminmlc_targetrule/product'))
    ->addColumn('rule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Rule Id')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Product Id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store Id')
    ->addIndex($installer->getIdxName('sminmlc_targetrule/product', array('product_id')),
        array('product_id'))
    ->addIndex($installer->getIdxName('sminmlc_targetrule/product', array('store_id')),
        array('store_id'))
    ->addForeignKey($installer->getFkName('sminmlc_targetrule/product', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('sminmlc_targetrule/product', 'product_id', 'catalog/product', 'entity_id'),
        'product_id', $installer->getTable('catalog/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('sminmlc_targetrule/product', 'rule_id', 'sminmlc_targetrule/rule', 'rule_id'),
        'rule_id', $installer->getTable('sminmlc_targetrule/rule'), 'rule_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Sminmlc Targetrule Product');
$installer->getConnection()->createTable($table);

/**
 * Create table 'sminmlc_targetrule/index'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('sminmlc_targetrule/index'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Entity Id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store Id')
    ->addColumn('customer_group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Customer Group Id')
    ->addColumn('type_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Type Id')
    ->addColumn('flag', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '1',
        ), 'Flag')
    ->addIndex($installer->getIdxName('sminmlc_targetrule/index', array('store_id')),
        array('store_id'))
    ->addIndex($installer->getIdxName('sminmlc_targetrule/index', array('customer_group_id')),
        array('customer_group_id'))
    ->addIndex($installer->getIdxName('sminmlc_targetrule/index', array('type_id')),
        array('type_id'))
    ->addForeignKey($installer->getFkName('sminmlc_targetrule/index', 'customer_group_id', 'customer/customer_group', 'customer_group_id'),
        'customer_group_id', $installer->getTable('customer/customer_group'), 'customer_group_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('sminmlc_targetrule/index', 'entity_id', 'catalog/product', 'entity_id'),
        'entity_id', $installer->getTable('catalog/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('sminmlc_targetrule/index', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Sminmlc Targetrule Index');
$installer->getConnection()->createTable($table);

/**
 * Create table 'sminmlc_targetrule/index_related'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('sminmlc_targetrule/index_related'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Entity Id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store Id')
    ->addColumn('customer_group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Customer Group Id')
    ->addColumn('product_ids', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Related Product Ids')
    ->addIndex($installer->getIdxName('sminmlc_targetrule/index_related', array('store_id')),
        array('store_id'))
    ->addIndex($installer->getIdxName('sminmlc_targetrule/index_related', array('customer_group_id')),
        array('customer_group_id'))
    ->addForeignKey($installer->getFkName('sminmlc_targetrule/index_related', 'customer_group_id', 'customer/customer_group', 'customer_group_id'),
        'customer_group_id', $installer->getTable('customer/customer_group'), 'customer_group_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('sminmlc_targetrule/index_related', 'entity_id', 'catalog/product', 'entity_id'),
        'entity_id', $installer->getTable('catalog/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('sminmlc_targetrule/index_related', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Sminmlc Targetrule Index Related');
$installer->getConnection()->createTable($table);

/**
 * Create table 'sminmlc_targetrule/index_upsell'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('sminmlc_targetrule/index_upsell'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Entity Id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store Id')
    ->addColumn('customer_group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Customer Group Id')
    ->addColumn('product_ids', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Upsell Product Ids')
    ->addIndex($installer->getIdxName('sminmlc_targetrule/index_upsell', array('store_id')),
        array('store_id'))
    ->addIndex($installer->getIdxName('sminmlc_targetrule/index_upsell', array('customer_group_id')),
        array('customer_group_id'))
    ->addForeignKey($installer->getFkName('sminmlc_targetrule/index_upsell', 'customer_group_id', 'customer/customer_group', 'customer_group_id'),
        'customer_group_id', $installer->getTable('customer/customer_group'), 'customer_group_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('sminmlc_targetrule/index_upsell', 'entity_id', 'catalog/product', 'entity_id'),
        'entity_id', $installer->getTable('catalog/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('sminmlc_targetrule/index_upsell', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Sminmlc Targetrule Index Upsell');
$installer->getConnection()->createTable($table);

/**
 * Create table 'sminmlc_targetrule/index_crosssell'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('sminmlc_targetrule/index_crosssell'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Entity Id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store Id')
    ->addColumn('customer_group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Customer Group Id')
    ->addColumn('product_ids', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'CrossSell Product Ids')
    ->addIndex($installer->getIdxName('sminmlc_targetrule/index_crosssell', array('store_id')),
        array('store_id'))
    ->addIndex($installer->getIdxName('sminmlc_targetrule/index_crosssell', array('customer_group_id')),
        array('customer_group_id'))
    ->addForeignKey($installer->getFkName('sminmlc_targetrule/index_crosssell', 'customer_group_id', 'customer/customer_group', 'customer_group_id'),
        'customer_group_id', $installer->getTable('customer/customer_group'), 'customer_group_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('sminmlc_targetrule/index_crosssell', 'entity_id', 'catalog/product', 'entity_id'),
        'entity_id', $installer->getTable('catalog/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('sminmlc_targetrule/index_crosssell', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Sminmlc Targetrule Index Crosssell');
$installer->getConnection()->createTable($table);

$installer->endSetup();
