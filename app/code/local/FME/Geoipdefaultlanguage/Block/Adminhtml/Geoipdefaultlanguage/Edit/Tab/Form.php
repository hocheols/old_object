<?php

class FME_Geoipdefaultlanguage_Block_Adminhtml_Geoipdefaultlanguage_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('geoipdefaultlanguage_form', array('legend' => Mage::helper('geoipdefaultlanguage')->__('Group information')));

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('geoipdefaultlanguage')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
        ));

        $fieldset->addField('priority', 'text', array(
            'label' => Mage::helper('geoipdefaultlanguage')->__('Priority'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'priority',
        ));

        $fieldset->addField('store', 'multiselect', array(
            'label' => Mage::helper('geoipdefaultlanguage')->__('Stores'),
            'required' => true,
            'name' => 'store',
            'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, false),
            'after_element_html' => Mage::helper('geoipdefaultlanguage')->__('<p><small>%s</small></p>','Select only one store view.')
        ));

        $fieldset->addField('currency', 'multiselect', array(
            'label' => Mage::helper('geoipdefaultlanguage')->__('Currency'),
            'name' => 'currency',
            'values' => Mage::helper("geoipdefaultlanguage")->getInstalledCurrencies(),
            'after_element_html' => "<p><small>" . Mage::helper('geoipdefaultlanguage')->__('(If the selected currency is allowed only then it will appear in frontend.)') . "</small></p>",
        ));


        $fieldset->addField('ip_to_exception', 'textarea', array(
            'name' => 'ip_to_exception',
            'label' => Mage::helper('geoipdefaultlanguage')->__('Exceptions'),
            'title' => Mage::helper('geoipdefaultlanguage')->__('Exceptions'),
            'style' => 'width:300px; height:200px;',
            'required' => false,
            'after_element_html' => "<p><small>" . Mage::helper('geoipdefaultlanguage')->__('(Provide ip\'s separated by ",". Wrong type of ips will be ignored!)') . "</small></p>"
        ));

        $fieldset->addField('notes', 'editor', array(
            'name' => 'notes',
            'label' => Mage::helper('geoipdefaultlanguage')->__('Content'),
            'title' => Mage::helper('geoipdefaultlanguage')->__('Content'),
            'style' => 'width:400px; height:300px;',
            'wysiwyg' => false,
            'required' => false,
            'after_element_html' => "<p><small>" . Mage::helper('geoipdefaultlanguage')->__('(Only for related settings, it won\'t appear on frontend.)') . "</small></p>",
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('geoipdefaultlanguage')->__('Status'),
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('geoipdefaultlanguage')->__('Enabled'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('geoipdefaultlanguage')->__('Disabled'),
                ),
            ),
        ));

        if (Mage::getSingleton('adminhtml/session')->getGeoipdefaultlanguageData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getGeoipdefaultlanguageData());
            Mage::getSingleton('adminhtml/session')->setGeoipdefaultlanguageData(null);
        } elseif (Mage::registry('geoipdefaultlanguage_data')) {
            $form->setValues(Mage::registry('geoipdefaultlanguage_data')->getData());
        }
        return parent::_prepareForm();
    }

}
