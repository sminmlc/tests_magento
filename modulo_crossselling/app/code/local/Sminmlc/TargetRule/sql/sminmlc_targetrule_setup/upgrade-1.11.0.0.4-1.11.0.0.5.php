<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

/* @var $installer Sminmlc_TargetRule_Model_Resource_Setup */
$installer = $this;

/**
 * Fill table 'sminmlc_targetrule/index_related_product'
 */
$select = $installer->getConnection()->select();
$select->from($installer->getTable('sminmlc_targetrule/index_related'), array('targetrule_id', 'product_ids'))
    ->where('`product_ids` <> ""');
$result = $installer->getConnection()->fetchAll($select);
$relatedProducts = array();
if ($result) {
    foreach($result as $row) {
        foreach(explode(',', $row['product_ids']) as $productId) {
            $relatedProducts[] = array('targetrule_id' => $row['targetrule_id'], 'product_id' => trim($productId));
        }
    }
    $installer->getConnection()->insertOnDuplicate(
        $installer->getTable('sminmlc_targetrule/index_related_product'),
        $relatedProducts,
        array('targetrule_id', 'product_id')
    );
}
/**
 * Fill table 'sminmlc_targetrule/index_crosssell_product'
 */
$select = $installer->getConnection()->select();
$select->from($installer->getTable('sminmlc_targetrule/index_crosssell'), array('targetrule_id', 'product_ids'))
    ->where('`product_ids` <> ""');
$result = $installer->getConnection()->fetchAll($select);
$crosssellProducts = array();
if ($result) {
    foreach($result as $row) {
        foreach(explode(',', $row['product_ids']) as $productId) {
            $crosssellProducts[] = array('targetrule_id' => $row['targetrule_id'], 'product_id' => trim($productId));
        }
    }
    $installer->getConnection()->insertOnDuplicate(
        $installer->getTable('sminmlc_targetrule/index_crosssell_product'),
        $crosssellProducts,
        array('targetrule_id', 'product_id')
    );
}
/**
 * Fill table 'sminmlc_targetrule/index_upsell_product'
 */
$select = $installer->getConnection()->select();
$select->from($installer->getTable('sminmlc_targetrule/index_upsell'), array('targetrule_id', 'product_ids'))
    ->where('`product_ids` <> ""');
$result = $installer->getConnection()->fetchAll($select);
$upsellProducts = array();
if ($result) {
    foreach($result as $row) {
        foreach(explode(',', $row['product_ids']) as $productId) {
            $upsellProducts[] = array('targetrule_id' => $row['targetrule_id'], 'product_id' => trim($productId));
        }
    }
    $installer->getConnection()->insertOnDuplicate(
        $installer->getTable('sminmlc_targetrule/index_upsell_product'),
        $upsellProducts,
        array('targetrule_id', 'product_id')
    );
}

$installer->getConnection()->modifyColumn(
    $installer->getTable('sminmlc_targetrule/index_related'),
    'product_ids',
    array(
        'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'  => 255,
        'comment' => 'Deprecated after 1.12.0.2'
    )
);

$installer->getConnection()->modifyColumn(
    $installer->getTable('sminmlc_targetrule/index_upsell'),
    'product_ids',
    array(
        'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'  => 255,
        'comment' => 'Deprecated after 1.12.0.2'
    )
);

$installer->getConnection()->modifyColumn(
    $installer->getTable('sminmlc_targetrule/index_crosssell'),
    'product_ids',
    array(
        'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'  => 255,
        'comment' => 'Deprecated after 1.12.0.2'
    )
);
