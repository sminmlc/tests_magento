<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$installer = $this;
$installer->startSetup();
$installer->run("
DROP TABLE IF EXISTS {$this->getTable('sminmlc_webservices_log_error')};
CREATE TABLE {$this->getTable('sminmlc_webservices_log_error')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `id_error` varchar(255) NOT NULL,
  `priority` varchar(15) NOT NULL,
  `desc_error` text NULL,
  `date` datetime NOT NULL,
  `increment_id` int(20) NOT NULL,
  `trace_input` text NULL,
  `trace_output` text NULL,
  `others` text NULL,
  `ws_method` varchar(30) NULL,
  `paid` smallint(6) default 0,
  `transaction_code` varchar(40) NULL,
  `customer` varchar(255) NOT NULL,
  `timestamp` timestamp default CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)    
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();
