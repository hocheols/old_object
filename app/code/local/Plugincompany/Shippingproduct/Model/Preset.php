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
class Plugincompany_Shippingproduct_Model_Preset extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('plugincompany_shippingproduct/preset');
    }

    protected function _afterSave()
    {
        $this
            ->removeProducts()
            ->addProducts()
        ;

        return parent::_afterSave();
    }

    public function removeProducts()
    {
        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection
            ->addAttributeToSelect('mb_preset_id')
            ->addAttributeToFilter('mb_preset_id', $this->getId());

        $ids = array();

        $keep = $this->getInPresetProducts();
        $keep = explode('&', $keep);

        foreach ($collection as $item) {
            if (!in_array($item->getId(), str_replace('=0','',$keep))) {
                $ids[] = $item->getId();
            }
        }

        try {
            Mage::getSingleton('catalog/product_action')
                ->updateAttributes($ids, array('mb_preset_id' => NULL), 0);
        } catch (Exception $e) {
            throw new Exception('Error removing products');
        }
        return $this;
    }

    public function addProducts()
    {
        $ids = $this->getInPresetProducts();
        if (!is_array($ids)) {
            $ids = explode('&', $ids);
        }

        $idds = array();
        foreach ($ids as $id) {
            if (!$id || !is_numeric($id)) {
                continue;
            }
            $idds[] = $id;
        }

        try {
            Mage::getSingleton('catalog/product_action')
                ->updateAttributes($idds, array('mb_preset_id'=>$this->getId()), 0);
        } catch (Exception $e) {
            throw new Exception('Error adding products');
        }
        return $this;
    }


}