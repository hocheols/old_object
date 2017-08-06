<?php

class FME_Geoipdefaultlanguage_Model_Store extends Mage_Core_Model_Store {

    /**
     * Get default store currency code
     *
     * @return string
     */
    public function getDefaultCurrencyCode() {

        $result = $this->getConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_DEFAULT); //echo $result;
        $remoteAddr = Mage::helper('core/http')->getRemoteAddr();
        
        try {
            
            $_helper = Mage::helper('geoipdefaultlanguage');
            $ipDets = $_helper->getInfoByIp($remoteAddr);
            $data = $_helper->infoGroups($ipDets)->getData(); //echo "<pre>";print_r($data->getData());echo "</pre>";exit;
            if (!empty($data)) {
                
                $result = "{$data[0]['currency']}"; // echo $result;exit;
            }
        } catch (Exception $ex) {

            Mage::log("Exception: " . $ex->getMessage());
        }

        return $result;
    }
    
   

}