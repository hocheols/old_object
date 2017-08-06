<?php

class FME_Geoipdefaultlanguage_Block_Adminhtml_Geoipdefaultlanguage_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('geoipdefaultlanguageGrid');
        $this->setDefaultSort('geoipdefaultlanguage_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('geoipdefaultlanguage/geoipdefaultlanguage')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('geoipdefaultlanguage_id', array(
            'header' => Mage::helper('geoipdefaultlanguage')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'geoipdefaultlanguage_id',
        ));

        $this->addColumn('title', array(
            'header' => Mage::helper('geoipdefaultlanguage')->__('Title'),
            'align' => 'left',
            'index' => 'title',
        ));

        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header' => Mage::helper('geoipdefaultlanguage')->__('Store View'),
                'index' => 'store',
                'type' => 'store',
                'store_all' => true,
                'store_view' => true,
                'sortable' => false,
                'filter_condition_callback'
                => array($this, '_filterStoreCondition'),
            ));
        }
        
        $this->addColumn('currency', array(
            'header' => Mage::helper('geoipdefaultlanguage')->__('Currency'),
            'align' => 'left',
            'index' => 'currency',
            'width' => '80px',
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('geoipdefaultlanguage')->__('Status'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                1 => 'Enabled',
                2 => 'Disabled',
            ),
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('geoipdefaultlanguage')->__('Action'),
            'width' => '100',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('geoipdefaultlanguage')->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'is_system' => true,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('geoipdefaultlanguage')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('geoipdefaultlanguage')->__('XML'));

        return parent::_prepareColumns();
    }

//    protected function _afterLoadCollection() {
//        $this->getCollection()->walk('afterLoad');
//        parent::_afterLoadCollection();
//    }

    protected function _filterStoreCondition($collection, $column) {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addStoreFilter($value);
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('geoipdefaultlanguage_id');
        $this->getMassactionBlock()->setFormFieldName('geoipdefaultlanguage');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('geoipdefaultlanguage')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('geoipdefaultlanguage')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('geoipdefaultlanguage/status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('geoipdefaultlanguage')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('geoipdefaultlanguage')->__('Status'),
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
