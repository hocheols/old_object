<?php
/**
 *
 * Created by:  Milan Simek
 * Company:     Plugin Company
 *
 * LICENSE: http://plugin.company/docs/magento-extensions/magento-extension-license-agreement
 *
 * YOU WILL ALSO FIND A PDF COPY OF THE LICENSE IN THE DOWNLOADED ZIP FILE
 *
 * FOR QUESTIONS AND SUPPORT
 * PLEASE DON'T HESITATE TO CONTACT US AT:
 *
 * SUPPORT@PLUGIN.COMPANY
 *
 */ 
class Plugincompany_Shippingproduct_Model_Resource_Preset_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('plugincompany_shippingproduct/preset');
    }

    protected function _toOptionArray($valueField='preset_id', $labelField='title', $additional=array())
    {
        $options = parent::_toOptionArray($valueField, $labelField, $additional);
        array_unshift($options, array('label' => "Don't use a preset", 'value' => 0));
        return $options;
    }

    protected function _toOptionHash($valueField='preset_id', $labelField='title')
    {
       $options = parent::_toOptionHash($valueField, $labelField);
        $options[0] = "Don't use a preset";
        return $options;
    }


}