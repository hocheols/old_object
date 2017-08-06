<?php

class FME_Geoipdefaultlanguage_Model_Observer {

    public function isEnableExt($store_id = null) {

        return Mage::getStoreConfig("geoipdefaultlanguage/main/enable", $store_id);
    }

    /**
     * redirect or do nothing
     * @param Varien_Event_Observer $observer
     * @return type mixed
     */
    public function setDefaultLang(Varien_Event_Observer $observer) {

        if (!$this->isEnableExt(Mage::app()->getStore()->getId())) {
            return;
        }
        
        $_helper = Mage::helper('geoipdefaultlanguage');
        $cookieName = 'store_selected';
        $cookiePeriod = $_helper->getCookieTime();
        // check if cookie is in browser
		$cookie = Mage::getModel('core/cookie')->get($cookieName); //echo '<pre>';var_dump($cookie);exit;
		if ($cookie !== false) { 
            //Mage::getModel('core/cookie')->delete($cookieName);exit;
			return;
		}
        
        $currentIp = Mage::helper('core/http')->getRemoteAddr(); //'46.108.108.240';
        $ipInfo = $_helper->getInfoByIp($currentIp); //echo '<pre>';print_r($ipInfo);exit;

        try {
            // collction object of group by ipinfo
            $groupInfoById = $_helper->infoGroups($ipInfo)->getData(); //echo '<pre>';print_r($groupInfoById);exit;

            if (empty($groupInfoById)) {
                return;
            }

            $ipFtrArr = array();
            if ($groupInfoById[0]['ip_to_exception'] != '') {

                $ipExcepArr = preg_split('@,@', $groupInfoById[0]['ip_to_exception'], NULL, PREG_SPLIT_NO_EMPTY);
                /* filter an array for bad ip input */
                $ipFtrArr = $_helper->validateIpFilter($ipExcepArr);
            }

            /* if current ip is not an exception, proceed */
            if (in_array($currentIp, $ipFtrArr)) {
                return;
            }

            $storeView = Mage::app()
				->getStore($groupInfoById[0]['store']); // the assigned store view for the current ip
            $storeCode = $storeView->getCode();
            // setting up cookies for the assigned store
            Mage::app()
				->getCookie()
				->set(Mage_Core_Model_Store::COOKIE_NAME, $storeCode, TRUE);
			Mage::app()
				->getCookie()
				->set(Mage_Core_Model_Store::COOKIE_CURRENCY, $groupInfoById[0]['currency'], TRUE);
			Mage::app()
				->setCurrentStore($storeCode);
			Mage::app()
				->getStore()
				->setCurrentCurrencyCode($groupInfoById[0]['currency']);
			
			$storeUrl = Mage::getModel('core/store')->load($storeView->getId())->getUrl('');
			// setting the cookie
			Mage::getModel('core/cookie')->set($cookieName, $storeCode, $cookiePeriod);
            header('Location:' . $storeUrl);
            return ;
            
        } catch (Exception $ex) {
            Mage::log($ex->getMessage());
        }
    }

    /**
     * second event to show custom output in footer
     * @param Varien_Event_Observer $observer
     * @return type mixed
     */
    public function showFooter(Varien_Event_Observer $observer) {

        if (!$this->isEnableExt(Mage::app()->getStore()->getId())) {
            return;
        }

        $layout = $observer->getEvent()->getLayout();
        $action = $observer->getEvent()->getAction();
        $layout->getUpdate()->addUpdate(
            '<reference name="footer">'
            . '<block type="geoipdefaultlanguage/geoipdefaultlanguage" name="fme.footer" after="-" template="geoipdefaultlanguage/footer.phtml"/>'
            . '</reference>'
        );

        $layout->generateXml();
    }

}
