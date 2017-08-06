<?php

class FME_Geoipdefaultlanguage_Block_Adminhtml_Geoipdefaultlanguage_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {

        parent::__construct();
        $this->setId('geoipdefaultlanguage_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('geoipdefaultlanguage')->__('Group Information'));
    }

    protected function _beforeToHtml() {

        $this->addTab('form_section', array(
            'label' => Mage::helper('geoipdefaultlanguage')->__('Group Information'),
            'title' => Mage::helper('geoipdefaultlanguage')->__('Group Information'),
            'content' => $this->getLayout()->createBlock('geoipdefaultlanguage/adminhtml_geoipdefaultlanguage_edit_tab_form')->toHtml(),
        ));

        $this->addTab('country_section', array(
            'label' => 'Add Countries to Group',
            'url' => $this->getUrl('*/*/getCountryListForm', array('_current' => true)),
            'class' => 'ajax',
        ));

        return parent::_beforeToHtml();
    }

}
