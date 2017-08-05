<?php

class Modulebazaar_Smscountry_Model_Mysql4_Log extends Mage_Core_Model_Resource_Db_Abstract{
    protected function _construct()
    {
        $this->_init('smscountry/log', 'id');
    }
}
