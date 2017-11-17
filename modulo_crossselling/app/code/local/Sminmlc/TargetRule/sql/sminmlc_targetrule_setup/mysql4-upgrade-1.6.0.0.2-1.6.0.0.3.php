<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

/** @var Sminmlc_TargetRule_Model_Mysql4_Setup */
$installer = $this;

$installer->getConnection()->modifyColumn(
    $installer->getTable('catalog/eav_attribute'), 'is_used_for_target_rules',
    "TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'deprecated after 1.7.1.0'"
);

$installer->run("UPDATE {$installer->getTable('catalog/eav_attribute')}
    SET is_used_for_promo_rules = is_used_for_promo_rules || is_used_for_target_rules;"
);
