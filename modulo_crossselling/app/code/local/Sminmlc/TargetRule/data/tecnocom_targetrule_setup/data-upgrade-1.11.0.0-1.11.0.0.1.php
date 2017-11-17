<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

/** @var $installer Sminmlc_TargetRule_Model_Resource_Setup */
$installer = $this;

if ($installer->getAttributeId('catalog_product', 'related_targetrule_position_limit')
    && !$installer->getAttributeId('catalog_product',  'related_tgtr_position_limit')
) {
    $installer->updateAttribute(
        Mage_Catalog_Model_Product::ENTITY,
        'related_targetrule_position_limit',
        'attribute_code',
        'related_tgtr_position_limit'
    );
}

if ($installer->getAttributeId('catalog_product', 'related_targetrule_position_behavior')
    && !$installer->getAttributeId('catalog_product', 'related_tgtr_position_behavior')
) {
    $installer->updateAttribute(
        Mage_Catalog_Model_Product::ENTITY,
        'related_targetrule_position_behavior',
        'attribute_code',
        'related_tgtr_position_behavior'
    );
}

if ($installer->getAttributeId('catalog_product', 'upsell_targetrule_position_limit')
    && !$installer->getAttributeId('catalog_product', 'upsell_tgtr_position_limit')
) {
    $installer->updateAttribute(
        Mage_Catalog_Model_Product::ENTITY,
        'upsell_targetrule_position_limit',
        'attribute_code',
        'upsell_tgtr_position_limit'
    );
}

if ($installer->getAttributeId('catalog_product', 'upsell_targetrule_position_behavior')
    && !$installer->getAttributeId('catalog_product', 'upsell_tgtr_position_behavior')
) {
    $installer->updateAttribute(
        Mage_Catalog_Model_Product::ENTITY,
        'upsell_targetrule_position_behavior',
        'attribute_code',
        'upsell_tgtr_position_behavior'
    );
}

