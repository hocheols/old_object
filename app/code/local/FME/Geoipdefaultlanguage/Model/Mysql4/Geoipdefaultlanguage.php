<?php

class FME_Geoipdefaultlanguage_Model_Mysql4_Geoipdefaultlanguage extends Mage_Core_Model_Mysql4_Abstract {

    public function _construct() {
        // Note that the geoipdefaultlanguage_id refers to the key field in your database table.
        $this->_init('geoipdefaultlanguage/geoipdefaultlanguage', 'geoipdefaultlanguage_id');
    }

}
