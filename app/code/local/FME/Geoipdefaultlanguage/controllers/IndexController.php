<?php

class FME_Geoipdefaultlanguage_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {

        $this->loadLayout();
        $this->renderLayout();
    }

    public function promptBoxAction() {
		
		$_helper = Mage::helper('geoipdefaultlanguage');
        $cookieName = 'store_selected';
        $cookiePeriod = $_helper->getCookieTime();
        
        if ($this->getRequest()->getPost("hid_prompt")) {
            //Mage::getSingleton("core/session")->setPromptStatus(now());
            if ($this->getRequest()->getPost('des_cookie')) {
				// set new cookie value
				$store = Mage::app()
					->getStore($this->getRequest()->getPost('store_id'));
				Mage::getModel('core/cookie')
					->set($cookieName, $store->getCode(), $cookiePeriod);
				Mage::app()
					->getCookie()
					->set(Mage_Core_Model_Store::COOKIE_NAME, $store->getCode(), TRUE);	
			}
			
            Mage::getModel('core/cookie')
				->set('prompt_status', 'no', Mage::helper('geoipdefaultlanguage')->getCookieTime());
            $this->getResponse()->setBody('1');
        }
    }

    public function initAjaxAction() {

        if ($this->getRequest()->getPost("initAjax")) {
            
            $url = '';
            $settings = explode(",", $this->getRequest()->getPost('settings'));

            switch ($this->getRequest()->getPost('type')) {

                case 'save_lang':
                    //$url = $settings[3];
                    Mage::app()->getCookie()->set(Mage_Core_Model_Store::COOKIE_NAME, $settings[0], TRUE);
                    break;
                case 'save_currency':
                    $store = Mage::app()->getStore()->getId();
                    if ($settings[0] != 'null') {
                        //$baseUrl = Mage::app()->getStore($settings[0])->getHomeUrl();
                        //$url = $baseUrl.Mage::app()->getStore($settings[0])->getCurrentUrl();
                        $store = $settings[0];
                        Mage::app()->getCookie()->set(Mage_Core_Model_Store::COOKIE_NAME, $store, TRUE);
                    }
                    Mage::app()->getStore($store)->setCurrentCurrencyCode($settings[1]);
                    break;
                case 'save_region':

                    break;
            }
            //echo Mage::app()->getRequest()->getServer('HTTP_REFERER');exit;
           $this->getResponse()->setBody('yes');
        }
    }

}
