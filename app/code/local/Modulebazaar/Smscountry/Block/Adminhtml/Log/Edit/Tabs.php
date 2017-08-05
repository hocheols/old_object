<?php

class Modulebazaar_Smscountry_Block_Adminhtml_Log_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('log_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('smscountry')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('smscountry')->__('Item Information'),
          'title'     => Mage::helper('smscountry')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('smscountry/adminhtml_log_edit_tab_form1')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}