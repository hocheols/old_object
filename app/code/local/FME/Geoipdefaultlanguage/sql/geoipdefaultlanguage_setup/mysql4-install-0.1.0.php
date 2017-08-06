<?php

$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('geoipdefaultlanguage')};
CREATE TABLE {$this->getTable('geoipdefaultlanguage')} (                                  
`geoipdefaultlanguage_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  
`title` varchar(255) NOT NULL DEFAULT '',                            
`priority` varchar(255) NOT NULL DEFAULT '',                         
`notes` text NOT NULL,                        
`store` int (255),                                      
`currency` varchar (255),                                      
`ip_to_exception` text,                                              
`countries_list` mediumtext,                                         
`status` smallint(6) NOT NULL DEFAULT '0',                           
`created_time` datetime DEFAULT NULL,                                
`update_time` datetime DEFAULT NULL,                                 
PRIMARY KEY (`geoipdefaultlanguage_id`)                              
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;");
$installer->setConfigData('geoipdefaultlanguage/main/enable', '1');
$installer->endSetup();
