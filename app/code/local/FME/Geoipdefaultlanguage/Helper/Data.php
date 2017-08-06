<?php

class FME_Geoipdefaultlanguage_Helper_Data extends Mage_Core_Helper_Abstract {

    const XML_PATH_BASIC_SHOW_PROMPT = 'geoipdefaultlanguage/basic/show_prompt';
    const XML_PATH_COOKIE_LIFETIME = 'web/cookie/cookie_lifetime';

    public function isShowPrompt($store = null) {

        if ($store == null) {
            $store = Mage::app()->getStore()->getId();
        }

        return Mage::getStoreConfig(self::XML_PATH_BASIC_SHOW_PROMPT, $store);
    }

    public function getCookieTime($store = null) {

        if ($store == null) {
            $store = Mage::app()->getStore()->getId();
        }

        $lifeTime = Mage::getStoreConfig(self::XML_PATH_COOKIE_LIFETIME, $store);
        if (!is_numeric($lifeTime)) {
            $lifeTime = 3600;
        }

        return $lifeTime;
    }

    public function getContinentsName($key) {
        $continentsArr = array(
            1 => 'Africa',
            2 => 'Asia',
            3 => 'Europe',
            4 => 'North_America',
            5 => 'Oceania',
            6 => 'South_America',
            7 => 'Others'
        );

        if (isset($continentsArr[$key])) {
            return $continentsArr[$key];
        }
    }

    public function allCmsPages() {
        $collection = Mage::getModel('cms/page')->getCollection()
                ->addFieldToFilter('is_active', 1);
        $_arr = array();

        foreach ($collection as $c) {
            $_arr[] = array(
                'label' => $c->getTitle(),
                'value' => $c->getIdentifier(),
            );
        }

        return $_arr;
    }

    public function checkVersion($version, $operator = '>=') {
        return version_compare(Mage::getVersion(), $version, $operator);
    }

    public function getcontinent($country = "") {
        switch ($country) {
            case "Algeria": {
                    $continent = 1;
                    break;
                }
            case "Angola": {
                    $continent = 1;
                    break;
                }
            case "Benin": {
                    $continent = 1;
                    break;
                }
            case "Botswana": {
                    $continent = 1;
                    break;
                }
            case "Burkina Faso": {
                    $continent = 1;
                    break;
                }
            case "Burundi": {
                    $continent = 1;
                    break;
                }
            case "Cameroon": {
                    $continent = 1;
                    break;
                }
            case "Cape Verde": {
                    $continent = 1;
                    break;
                }
            case "Central African Republic": {
                    $continent = 1;
                    break;
                }
            case "Chad": {
                    $continent = 1;
                    break;
                }
            case "Comoros": {
                    $continent = 1;
                    break;
                }
            case "Congo": {
                    $continent = 1;
                    break;
                }
            case "Congo, The Democratic Republic of the": {
                    $continent = 1;
                    break;
                }
            case "Djibouti": {
                    $continent = 1;
                    break;
                }
            case "Egypt": {
                    $continent = 1;
                    break;
                }
            case "Equatorial Guinea": {
                    $continent = 1;
                    break;
                }
            case "Eritrea": {
                    $continent = 1;
                    break;
                }
            case "Ethiopia": {
                    $continent = 1;
                    break;
                }
            case "Gabon": {
                    $continent = 1;
                    break;
                }
            case "Gambia": {
                    $continent = 1;
                    break;
                }
            case "Ghana": {
                    $continent = 1;
                    break;
                }
            case "Guinea": {
                    $continent = 1;
                    break;
                }
            case "Guinea-Bissau": {
                    $continent = 1;
                    break;
                }
            case "Cote D'Ivoire": {
                    $continent = 1;
                    break;
                }
            case "Kenya": {
                    $continent = 1;
                    break;
                }
            case "Lesotho": {
                    $continent = 1;
                    break;
                }
            case "Liberia": {
                    $continent = 1;
                    break;
                }
            case "Libyan Arab Jamahiriya": {
                    $continent = 1;
                    break;
                }
            case "Madagascar": {
                    $continent = 1;
                    break;
                }
            case "Malawi": {
                    $continent = 1;
                    break;
                }
            case "Mali": {
                    $continent = 1;
                    break;
                }
            case "Mauritania": {
                    $continent = 1;
                    break;
                }
            case "Mauritius": {
                    $continent = 1;
                    break;
                }
            case "Morocco": {
                    $continent = 1;
                    break;
                }
            case "Mozambique": {
                    $continent = 1;
                    break;
                }
            case "Namibia": {
                    $continent = 1;
                    break;
                }
            case "Niger": {
                    $continent = 1;
                    break;
                }
            case "Nigeria": {
                    $continent = 1;
                    break;
                }
            case "Rwanda": {
                    $continent = 1;
                    break;
                }
            case "Sao Tome and Principe": {
                    $continent = 1;
                    break;
                }
            case "Senegal": {
                    $continent = 1;
                    break;
                }
            case "Seychelles": {
                    $continent = 1;
                    break;
                }
            case "Sierra Leone": {
                    $continent = 1;
                    break;
                }
            case "Somalia": {
                    $continent = 1;
                    break;
                }
            case "South Africa": {
                    $continent = 1;
                    break;
                }
            case "Sudan": {
                    $continent = 1;
                    break;
                }
            case "Swaziland": {
                    $continent = 1;
                    break;
                }
            case "Tanzania, United Republic of": {
                    $continent = 1;
                    break;
                }
            case "Togo": {
                    $continent = 1;
                    break;
                }
            case "Tunisia": {
                    $continent = 1;
                    break;
                }
            case "Uganda": {
                    $continent = 1;
                    break;
                }
            case "Zambia": {
                    $continent = 1;
                    break;
                }
            case "Zimbabwe": {
                    $continent = 1;
                    break;
                }
            case "Afghanistan": {
                    $continent = 2;
                    break;
                }
            case "Bahrain": {
                    $continent = 2;
                    break;
                }
            case "Bangladesh": {
                    $continent = 2;
                    break;
                }
            case "Bhutan": {
                    $continent = 2;
                    break;
                }
            case "Brunei Darussalam": {
                    $continent = 2;
                    break;
                }
            case "Myanmar": {
                    $continent = 2;
                    break;
                }
            case "Cambodia": {
                    $continent = 2;
                    break;
                }
            case "China": {
                    $continent = 2;
                    break;
                }
            case "Timor-Leste": {
                    $continent = 2;
                    break;
                }
            case "India": {
                    $continent = 2;
                    break;
                }
            case "Indonesia": {
                    $continent = 2;
                    break;
                }
            case "Iran, Islamic Republic of": {
                    $continent = 2;
                    break;
                }
            case "Iraq": {
                    $continent = 2;
                    break;
                }
            case "Israel": {
                    $continent = 2;
                    break;
                }
            case "Japan": {
                    $continent = 2;
                    break;
                }
            case "Jordan": {
                    $continent = 2;
                    break;
                }
            case "Kazakhstan": {
                    $continent = 2;
                    break;
                }
            case "Korea, Democratic People's Republic of": {
                    $continent = 2;
                    break;
                }
            case "Korea, Republic of": {
                    $continent = 2;
                    break;
                }
            case "Kuwait": {
                    $continent = 2;
                    break;
                }
            case "Kyrgyzstan": {
                    $continent = 2;
                    break;
                }
            case "Lao People's Democratic Republic": {
                    $continent = 2;
                    break;
                }
            case "Lebanon": {
                    $continent = 2;
                    break;
                }
            case "Malaysia": {
                    $continent = 2;
                    break;
                }
            case "Maldives": {
                    $continent = 2;
                    break;
                }
            case "Mongolia": {
                    $continent = 2;
                    break;
                }
            case "Nepal": {
                    $continent = 2;
                    break;
                }
            case "Oman": {
                    $continent = 2;
                    break;
                }
            case "Pakistan": {
                    $continent = 2;
                    break;
                }
            case "Philippines": {
                    $continent = 2;
                    break;
                }
            case "Qatar": {
                    $continent = 2;
                    break;
                }
            case "Russian Federation": {
                    $continent = 2;
                    break;
                }
            case "Saudi Arabia": {
                    $continent = 2;
                    break;
                }
            case "Singapore": {
                    $continent = 2;
                    break;
                }
            case "Sri Lanka": {
                    $continent = 2;
                    break;
                }
            case "Syrian Arab Republic": {
                    $continent = 2;
                    break;
                }
            case "Tajikistan": {
                    $continent = 2;
                    break;
                }
            case "Thailand": {
                    $continent = 2;
                    break;
                }
            case "Turkey": {
                    $continent = 2;
                    break;
                }
            case "Turkmenistan": {
                    $continent = 2;
                    break;
                }
            case "United Arab Emirates": {
                    $continent = 2;
                    break;
                }
            case "Uzbekistan": {
                    $continent = 2;
                    break;
                }
            case "Vietnam": {
                    $continent = 2;
                    break;
                }
            case "Yemen": {
                    $continent = 2;
                    break;
                }
            case "Albania": {
                    $continent = 3;
                    break;
                }
            case "Andorra": {
                    $continent = 3;
                    break;
                }
            case "Armenia": {
                    $continent = 3;
                    break;
                }
            case "Austria": {
                    $continent = 3;
                    break;
                }
            case "Azerbaijan": {
                    $continent = 3;
                    break;
                }
            case "Belarus": {
                    $continent = 3;
                    break;
                }
            case "Belgium": {
                    $continent = 3;
                    break;
                }
            case "Bosnia and Herzegovina": {
                    $continent = 3;
                    break;
                }
            case "Bulgaria": {
                    $continent = 3;
                    break;
                }
            case "Croatia": {
                    $continent = 3;
                    break;
                }
            case "Cyprus": {
                    $continent = 3;
                    break;
                }
            case "Czech Republic": {
                    $continent = 3;
                    break;
                }
            case "Denmark": {
                    $continent = 3;
                    break;
                }
            case "Estonia": {
                    $continent = 3;
                    break;
                }
            case "Finland": {
                    $continent = 3;
                    break;
                }
            case "France": {
                    $continent = 3;
                    break;
                }
            case "Georgia": {
                    $continent = 3;
                    break;
                }
            case "Germany": {
                    $continent = 3;
                    break;
                }
            case "Greece": {
                    $continent = 3;
                    break;
                }
            case "Hungary": {
                    $continent = 3;
                    break;
                }
            case "Iceland": {
                    $continent = 3;
                    break;
                }
            case "Ireland": {
                    $continent = 3;
                    break;
                }
            case "Italy": {
                    $continent = 3;
                    break;
                }
            case "Latvia": {
                    $continent = 3;
                    break;
                }
            case "Liechtenstein": {
                    $continent = 3;
                    break;
                }
            case "Lithuania": {
                    $continent = 3;
                    break;
                }
            case "Luxembourg": {
                    $continent = 3;
                    break;
                }
            case "Macedonia": {
                    $continent = 3;
                    break;
                }
            case "Malta": {
                    $continent = 3;
                    break;
                }
            case "Moldova, Republic of": {
                    $continent = 3;
                    break;
                }
            case "Monaco": {
                    $continent = 3;
                    break;
                }
            case "Montenegro": {
                    $continent = 3;
                    break;
                }
            case "Netherlands": {
                    $continent = 3;
                    break;
                }
            case "Norway": {
                    $continent = 3;
                    break;
                }
            case "Poland": {
                    $continent = 3;
                    break;
                }
            case "Portugal": {
                    $continent = 3;
                    break;
                }
            case "Romania": {
                    $continent = 3;
                    break;
                }
            case "San Marino": {
                    $continent = 3;
                    break;
                }
            case "Serbia": {
                    $continent = 3;
                    break;
                }
            case "Slovakia": {
                    $continent = 3;
                    break;
                }
            case "Slovenia": {
                    $continent = 3;
                    break;
                }
            case "Spain": {
                    $continent = 3;
                    break;
                }
            case "Sweden": {
                    $continent = 3;
                    break;
                }
            case "Switzerland": {
                    $continent = 3;
                    break;
                }
            case "Ukraine": {
                    $continent = 3;
                    break;
                }
            case "United Kingdom": {
                    $continent = 3;
                    break;
                }
            case "Antigua and Barbuda": {
                    $continent = 4;
                    break;
                }
            case "Bahamas": {
                    $continent = 4;
                    break;
                }
            case "Barbados": {
                    $continent = 4;
                    break;
                }
            case "Belize": {
                    $continent = 4;
                    break;
                }
            case "Canada": {
                    $continent = 4;
                    break;
                }
            case "Costa Rica": {
                    $continent = 4;
                    break;
                }
            case "Cuba": {
                    $continent = 4;
                    break;
                }
            case "Dominica": {
                    $continent = 4;
                    break;
                }
            case "Dominican Republic": {
                    $continent = 4;
                    break;
                }
            case "El Salvador": {
                    $continent = 4;
                    break;
                }
            case "Grenada": {
                    $continent = 4;
                    break;
                }
            case "Guatemala": {
                    $continent = 4;
                    break;
                }
            case "Haiti": {
                    $continent = 4;
                    break;
                }
            case "Honduras": {
                    $continent = 4;
                    break;
                }
            case "Jamaica": {
                    $continent = 4;
                    break;
                }
            case "Mexico": {
                    $continent = 4;
                    break;
                }
            case "Nicaragua": {
                    $continent = 4;
                    break;
                }
            case "Panama": {
                    $continent = 4;
                    break;
                }
            case "Saint Kitts and Nevis": {
                    $continent = 4;
                    break;
                }
            case "Saint Lucia": {
                    $continent = 4;
                    break;
                }
            case "Saint Vincent and the Grenadines": {
                    $continent = 4;
                    break;
                }
            case "Trinidad and Tobago": {
                    $continent = 4;
                    break;
                }
            case "United States": {
                    $continent = 4;
                    break;
                }
            case "Australia": {
                    $continent = 5;
                    break;
                }
            case "Fiji": {
                    $continent = 5;
                    break;
                }
            case "Kiribati": {
                    $continent = 5;
                    break;
                }
            case "Marshall Islands": {
                    $continent = 5;
                    break;
                }
            case "Micronesia, Federated States of": {
                    $continent = 5;
                    break;
                }
            case "Nauru": {
                    $continent = 5;
                    break;
                }
            case "New Zealand": {
                    $continent = 5;
                    break;
                }
            case "Palau": {
                    $continent = 5;
                    break;
                }
            case "Papua New Guinea": {
                    $continent = 5;
                    break;
                }
            case "Samoa": {
                    $continent = 5;
                    break;
                }
            case "Solomon Islands": {
                    $continent = 5;
                    break;
                }
            case "Tonga": {
                    $continent = 5;
                    break;
                }
            case "Tuvalu": {
                    $continent = 5;
                    break;
                }
            case "Vanuatu": {
                    $continent = 5;
                    break;
                }
            case "Argentina": {
                    $continent = 6;
                    break;
                }
            case "Bolivia": {
                    $continent = 6;
                    break;
                }
            case "Brazil": {
                    $continent = 6;
                    break;
                }
            case "Chile": {
                    $continent = 6;
                    break;
                }
            case "Colombia": {
                    $continent = 6;
                    break;
                }
            case "Ecuador": {
                    $continent = 6;
                    break;
                }
            case "Guyana": {
                    $continent = 6;
                    break;
                }
            case "Paraguay": {
                    $continent = 6;
                    break;
                }
            case "Peru": {
                    $continent = 6;
                    break;
                }
            case "Suriname": {
                    $continent = 6;
                    break;
                }
            case "Uruguay": {
                    $continent = 6;
                    break;
                }
            case "Venezuela": {
                    $continent = 6;
                    break;
                }

            default: {
                    $continent = 7;
                }
        }

        return $continent;
    }

    public function getCountries() {
        try {
            //get read connection
            $resource = Mage::getSingleton('core/resource');
            $readConnection = $resource->getConnection('core_read');
            $table_cl = $resource->getTableName('geoip_cl');
            $query = "SELECT * FROM {$table_cl} ORDER BY cn";
            $results = $readConnection->fetchAll($query);
            return $results;
        } catch (Exception $ex) {
            
        }
    }

    public function getGroupedCountries($groupId) {
        try {
            //get read connection
            $resource = Mage::getSingleton('core/resource');

            $read = $resource->getConnection('core_read');

            $table = $resource->getTableName('geoipdefaultlanguage');
            $query = "SELECT countries_list 
                    FROM {$table} 
                    WHERE geoipdefaultlanguage_id = '{$groupId}'";
            $results = $read->fetchRow($query); //echo '<pre>';print_r(unserialize($results['countries_list']));echo '</pre>';//exit;

            return unserialize($results['countries_list']);
        } catch (Exception $ex) {
            
        }
    }

    public function showDefaultStoreViews() {

        $storeViews = Mage::app()->getStores(); //Mage::getModel("core/store")->getCollection();// 
        $_views = array();
        foreach ($storeViews as $view) {

            $_views[] = array(
                "value" => $view->getStoreId(),
                "label" => Mage::helper("geoipdefaultlanguage")->__($view->getName()),
            );
        }

        return $_views;
    }

    public function getInfoByIp($remoteIp) {
        $result = array();
        if (filter_var($remoteIp, FILTER_VALIDATE_IP)) {

            try {
                $res = Mage::getSingleton('core/resource');
                $read = $res->getConnection('core_read');
                $select = $read->select()
                        ->from(array('gcsv' => $res->getTableName('geoip_csv')))
                        ->where('gcsv.end >= INET_ATON(?)', $remoteIp) // reference: http://andy.wordpress.com/2007/12/16/fast-mysql-range-queries-on-maxmind-geoip-tables/
                        ->order('gcsv.end ASC')
                        ->limit(1);
                return $read->fetchRow($select);
            } catch (Exception $ex) {
                $result = array();
            }
        }

        return $result;
    }

    public function validateIpFilter($ipArr) {

        $newIpArr = array();
        foreach ($ipArr as $ip) {
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                $newIpArr[] = $ip;
            }
        }
        return $newIpArr;
    }

    /**
     * Retrieve Installed Currencies
     *
     * @return array
     */
    public function getInstalledCurrencies() {

        //return explode(',', Mage::getStoreConfig('system/currency/installed'));
        //$obj = new Mage_Adminhtml_Model_System_Config_Source_Locale_Currency_All();
        /*
          $localeModel = new Mage_Core_Model_Locale();

          $currList = $localeModel->getTranslationList("currencytoname"); //echo "<pre>";print_r($currList);echo "</pre>";
          $finalArr = array();

          foreach ($currList as $name => $code) {
          $finalArr[] = array(
          "value" => $code,
          "label" => $name ." ({$code})",
          );
          }// echo "<pre>";print_r($finalArr);echo "</pre>";

          return $finalArr;
         */

        $options = Mage::app()->getLocale()->getOptionAllCurrencies(); //echo "<pre>";print_r($options);echo "</pre>";
        array_unshift($options, array('value' => '', 'label' => 'Select Currency'));
        return $options;
    }

    public function visitorIpInfo($currentIp = null) {

        if ($currentIp == null) {
            $currentIp = Mage::helper('core/http')->getRemoteAddr();
        }

        $remoteAddr = ip2long($currentIp); // convert ip into remote address
        $ipInfo = $this->getInfoByIp($currentIp); //getting country name code by rmeote addr , if exists.

        return $ipInfo;
    }

    public function getAnyStore($code = null) {

        foreach (Mage::app()->getStores() as $store) {

            if (!is_null($code)) {
                if (is_int($code)) {
                    if ($store->getId() == $code) {

                        return $store;
                    } elseif ($store->getCode() == $code) {

                        return $store;
                    }
                }
            } else {
                $MageDefStoreId = Mage::app()->getWebsite()->getDefaultGroup()->getDefaultStoreId(); // default magento store id
                foreach (Mage::app()->getStores() as $store) {
                    if ($store->getId() == $MageDefStoreId) {
                        return $store;
                    }
                }
            }
        }

        return null;
    }

    /**
     * get collection by gathered IP info
     * @param type $arr
     * @return type mixed <object, empty>
     */
    public function infoGroups($arr) {

        $continent = $this->getcontinent($arr['cn']);
        $continentName = $this->getContinentsName($continent);
        
        $expression = new Zend_Db_Expr('LOWER(countries_list)');
        
        $model = Mage::getModel('geoipdefaultlanguage/geoipdefaultlanguage');
        $collection = $model->getCollection()
                ->addFieldToFilter('countries_list', array('neq' => ''))
                ->addFieldToFilter($expression, array('like' => '%' . strtolower($arr['cn']) . '%'))
                ->addStatusFilter();

        //echo (string) $collection->getSelect();exit;
        // fetching falling group if more than one than with priority limit 1
        $storeViewIds = array();

        foreach ($collection as $item) {
            /*
              $countriesList = unserialize($item->getCountriesList());

              if (!in_array($arr['cn'], $countriesList[strtolower($continentName)])) {

              continue;
              }
             */
            $storeViewIds[] = $item->getId();
        }
        // now get group id based on priority
        $collection->setPriorityOrder()
                ->addIdsFilter($storeViewIds)
                ->applyLimit();

        return $collection;
    }

}
