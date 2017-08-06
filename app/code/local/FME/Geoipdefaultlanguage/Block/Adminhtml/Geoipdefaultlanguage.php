<?php

class FME_Geoipdefaultlanguage_Block_Adminhtml_Geoipdefaultlanguage extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = 'adminhtml_geoipdefaultlanguage';
        $this->_blockGroup = 'geoipdefaultlanguage';
        $this->_headerText = Mage::helper('geoipdefaultlanguage')->__('Group Manager');
        $this->_addButtonLabel = Mage::helper('geoipdefaultlanguage')->__('Add Group');
        parent::__construct();
    }

}
