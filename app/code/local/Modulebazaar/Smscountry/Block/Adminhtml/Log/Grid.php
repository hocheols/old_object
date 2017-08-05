<?php

class Modulebazaar_Smscountry_Block_Adminhtml_Log_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('log_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('smscountry/log')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('id', array(
            'header' => Mage::helper('smscountry')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'id',
        ));

        $this->addColumn('sent_date', array(
            'header' => Mage::helper('smscountry')->__('Send Date'),
            'index' => 'sent_date',
            'type' => 'datetime',
            'width' => '100px',
        ));

        $this->addColumn('title', array(
            'header' => Mage::helper('smscountry')->__('Title'),
            'align' => 'left',
            'index' => 'title',
        ));

        $this->addColumn('to', array(
            'header' => Mage::helper('smscountry')->__('To'),
            'align' => 'left',
            'index' => 'to',
            'filter_index' => 'main_table.to',
        ));
        
        $this->addColumn('recipient', array(
            'header' => Mage::helper('smscountry')->__('Recipient'),
            'align' => 'left',
            'index' => 'recipient',
        ));
        
        $this->addColumn('country', array(
            'header' => Mage::helper('smscountry')->__('Country'),
            'align' => 'left',
            'index' => 'country',
        ));
        
        $this->addColumn('chars', array(
            'header' => Mage::helper('smscountry')->__('Chars'),
            'align' => 'left',
            'index' => 'chars',
        ));
        
        $this->addColumn('length', array(
            'header' => Mage::helper('smscountry')->__('Length'),
            'align' => 'left',
            'index' => 'length',
        ));
        
        $this->addColumn('status', array(
            'header' => Mage::helper('smscountry')->__('Status'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                1 => 'Sent',
                2 => 'Not Sent',
            ),
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('smscountry');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('smscountry')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('smscountry')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('smscountry/status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('smscountry')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('smscountry')->__('Status'),
                    'values' => $statuses
                )
            )
        ));
        return $this;
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}