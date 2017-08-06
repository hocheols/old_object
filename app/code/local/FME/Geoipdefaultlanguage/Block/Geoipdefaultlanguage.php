<?php

class FME_Geoipdefaultlanguage_Block_Geoipdefaultlanguage extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getGeoipdefaultlanguage() {
        if (!$this->hasData('geoipdefaultlanguage')) {
            $this->setData('geoipdefaultlanguage', Mage::registry('geoipdefaultlanguage'));
        }
        return $this->getData('geoipdefaultlanguage');
    }

    public function isEnableExt() {
        return Mage::getStoreConfig("geoipdefaultlanguage/basic/show_prompt");
    }

}
