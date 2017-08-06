<?php

class FME_Geoipdefaultlanguage_Block_Adminhtml_Importtables extends Mage_Adminhtml_Block_Widget_Tabs {
    public function __construct() {
        parent::__construct();
        $this->setTemplate('geoipdefaultlanguage/importtables.phtml');
        $this->setFormAction(Mage::getUrl('*/importgeotables/updateTables'));
    }

    protected function _beforeToHtml() {
        return parent::_beforeToHtml();
    }

	   public function getHeaderCssClass() 
    {
        return 'icon-head head-products';
    }
}
