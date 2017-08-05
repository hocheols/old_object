<?php

class Modulebazaar_Smscountry_Block_Adminhtml_Log_Edit_Tab_Form1 extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        if (Mage::getSingleton('adminhtml/session')->getLogData()) {
            $data = Mage::getSingleton('adminhtml/session')->getLoglData();
            Mage::getSingleton('adminhtml/session')->getLogData(null);
        } elseif (Mage::registry('log_data')) {
            $data = Mage::registry('log_data')->getData();
        } else {
            $data = array();
        }

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('log_form', array(
            'legend' => Mage::helper('smscountry')->__('Log Information')
                ));

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('smscountry')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
        ));

        $fieldset->addField('filename', 'file', array(
            'label' => Mage::helper('smscountry')->__('File'),
            'required' => false,
            'name' => 'filename',
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('smscountry')->__('Status'),
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('smscountry')->__('Sent'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('smscountry')->__('Not Sent'),
                ),
            ),
        ));

        $fieldset->addField('content', 'editor', array(
            'name' => 'content',
            'label' => Mage::helper('smscountry')->__('Content'),
            'title' => Mage::helper('smscountry')->__('Content'),
            'style' => 'width:700px; height:500px;',
            'wysiwyg' => false,
            'required' => true,
        ));

        $form->setValues($data);

        return parent::_prepareForm();
    }

}
