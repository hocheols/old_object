<?php

class Modulebazaar_Smscountry_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('smscountry')->__('Sent'),
            self::STATUS_DISABLED   => Mage::helper('smscountry')->__('Not Sent')
        );
    }
}