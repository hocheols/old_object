<?php
 
class Modulebazaar_Smscountry_Block_Adminhtml_Log extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected $_addButtonLabel = 'Add New Log';
 
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_log';
        $this->_blockGroup = 'smscountry';
        $this->_headerText = Mage::helper('smscountry')->__('Logs');
        $this->removeButton('add'); 
    }
}