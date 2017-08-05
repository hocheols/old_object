<?php
class Modulebazaar_Smscountry_IndexController extends Mage_Core_Controller_Front_Action
{
    public function licenceAction()
    {
       echo Mage::helper('smscountry')->valitityCheck();
    }
}