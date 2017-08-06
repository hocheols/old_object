<?php

class FME_Geoipdefaultlanguage_Block_Adminhtml_Geoipdefaultlanguage_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'geoipdefaultlanguage';
        $this->_controller = 'adminhtml_geoipdefaultlanguage';

        $this->_updateButton('save', 'label', Mage::helper('geoipdefaultlanguage')->__('Save Group'));
        $this->_updateButton('delete', 'label', Mage::helper('geoipdefaultlanguage')->__('Delete Group'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
                ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('notes') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'notes');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'notes');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText() {
        if (Mage::registry('geoipdefaultlanguage_data') && Mage::registry('geoipdefaultlanguage_data')->getId()) {
            return Mage::helper('geoipdefaultlanguage')->__("Edit Group '%s'", $this->htmlEscape(Mage::registry('geoipdefaultlanguage_data')->getTitle()));
        } else {
            return Mage::helper('geoipdefaultlanguage')->__('Add Group');
        }
    }

}
