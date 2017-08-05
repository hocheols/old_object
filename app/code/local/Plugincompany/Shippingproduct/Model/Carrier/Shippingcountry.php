<?php
/*
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
 */
?>
<?php

/**
 * Class Plugincompany_Shippingproduct_Model_Carrier_Shippingcountry
 */
class Plugincompany_Shippingproduct_Model_Carrier_Shippingcountry
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{
    /**
     * @var string
     */
    protected $_code = 'shippingcountry';

    protected $_skusProcessed = array();

    /**
     * Collect rates for this shipping method based on information in $request
     *
     * @param Mage_Shipping_Model_Rate_Request $data
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {

        //check if enabled
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $coutryId = $request->getDestCountryId();

        if ($request->getAllItems()) {
            $perordertotal = 0;
            $perorderoverride = 0;
            $perorderoverridecount = 0;

            foreach ($request->getAllItems() as $item) {
                if ($item->getProduct()->isVirtual() || $item->getProductType() == 'configurable') {
                    continue;
                }

                //get product depending on configurable product settings
                $_product = $this->_getProduct($item);
                if(!$_product){
                    continue;
                }

                //get qty for SKU, depending on shipping SKU settings
                $qty = $this->_getQty($item,$_product,$request->getAllItems());
                if(!$qty){
                    continue;
                }

                $presetId = $_product->getMbPresetId();
                if($presetId){
                    $preset = Mage::getModel('plugincompany_shippingproduct/preset')->load($presetId);
                    $shippingPerCountry = $preset->getShippingPerCountry();
                    $override = $preset->getOverride();
                    $peritem = $preset->getPerItem();
                }else{
                    //if preset values are not set, load product values
                    $shippingPerCountry = $_product->getMbShippingPerCountry();
                    $override = null;
                    $peritem = null;
                }

                //get product country / rate array
                $productrates = $this->getvaluearray($shippingPerCountry);

                //check if rate is defined for country
                if (array_key_exists($coutryId, $productrates)) {
                    $countryrate = $productrates[$coutryId];

                //get default rate if rate is not defined
                } elseif (array_key_exists('-', $productrates)) {
                    $countryrate = $productrates['-'];

                //get config value if no default rate is defined
                } else {
                    $countryrate = $this->getDefaultCountryRate($coutryId);
                }

                //if free shipping, rate is 0
                if ($item->getFreeShipping()) {
                    $countryrate = 0;
                }

                //check for override total setting
                //if preset values are not set, load product values
                if (!isset($override)) {
                    $override = $_product->getMbOverride();
                }

                //if value 0 or no value, use config settings
                if (!$override) {
                    $override = $this->getConfigData('mb_standard_override');
                }

                //check per SKU or per item setting
                //if preset values are not set, load product values
                if (!isset($peritem)) {
                    $peritem = $_product->getMbPerItem();
                }

                //if value 0 or no value, use config settings
                if (!$peritem) {
                    $peritem = $this->getConfigData('mb_standard_per_item');
                }

                //Override totals
                if ($override == 2) {
                    $perorderoverridecount++;

                    //Override totals & Per SKU calculation
                    if ($peritem == 2 ) {
                        if($countryrate > $perorderoverride){
                            //replace order override total, if product rate is higher than current override total
                            $perorderoverride = $countryrate;
                        }
                    //Override totals & Per item calculation
                    } elseif ($countryrate * $qty > $perorderoverride) {
                        //replace order override total, if product rate is higher than current override total
                        $perorderoverride = $countryrate * $qty;
                    }

                //No override & Per SKU calculation
                } elseif ($peritem == 2) {
                    //add rate to no override total
                    $perordertotal += $countryrate;

                //No override & per item calculation
                } else {
                    //add rate to no override total
                    $perordertotal += $countryrate * $qty;
                }
            }

            //shipping rate total override is active
            if ($perorderoverridecount > 0) {
                $total = $perorderoverride;

            //no override, use 'normal' rate
            } else {
                $total = $perordertotal;
            }

            //add fixed fee
            $total += $this->getFixedOrderFee($coutryId);

            //if free shipping is active, total is 0
            if ($request->getFreeShipping() === true) {
                $total = 0;
            }

            //build shipping rate result object and return
            $result = Mage::getModel('shipping/rate_result');
            $method = Mage::getModel('shipping/rate_result_method');
            $method->setCarrier($this->_code);
            $method->setCarrierTitle($this->getConfigData('title'));
            $method->setMethod($this->_code);
            $method->setMethodTitle($this->getConfigData('name'));
            $method->setPrice($total);
            $method->setCost($total);
            $result->append($method);
            return $result;
        }
    }


    /**
     * Creates array from country / rate database string
     *
     * @param $values
     * @return array|bool
     */
    public function getvaluearray($values)
    {
        if ($values && $values != ';') {
            $values = trim($values, '; ');
            $values = explode(';', $values);
            foreach ($values as $k => $v) {
                $values[$k] = explode(':', $v);
            }
            $ret = array();
            foreach ($values as $v) {
                $key = $v[0];
                $ret[$key] = $v[1];
            }
            return $ret;
        }

        return array();

    }

    /**
     * Returns default rate for country from config settings
     *
     * @param $countryId
     * @return int
     */
    public function getDefaultCountryRate($countryId)
    {
        $defaultRates = $this->getConfigData('mb_standard_rate');
        $productrates = $this->getvaluearray($defaultRates);

        $countryrate = 0;
        if (array_key_exists($countryId, $productrates)) {
            $countryrate = $productrates[$countryId];
        } elseif (array_key_exists('-', $productrates)) {
            $countryrate = $productrates['-'];
        }
        return $countryrate;
    }

    /**
     * Get fixed order fee for country
     *
     * @param $countryId
     * @return int
     */
    public function getFixedOrderFee($countryId){
        //get product country / rate array
        $feeRates = $this->getConfigData('mb_fixed_fee');
        $feeRates = $this->getvaluearray($feeRates);

        $countryrate = 0;

        //check if rate is defined for country
        if (array_key_exists($countryId, $feeRates)) {
            $countryrate = $feeRates[$countryId];

            //get default rate if rate is not defined
        } elseif (array_key_exists('-', $feeRates)) {
            $countryrate = $feeRates['-'];
        }

        return $countryrate;
    }

    /**
     * Get product specific rate for country
     *
     * @param $_product
     * @param null $countryId
     * @return int
     */
    public function getShippingRateForProduct($_product,$countryId = null)
    {
        $presetId = $_product->getMbPresetId();
        if($presetId){
            $preset = Mage::getModel('plugincompany_shippingproduct/preset')->load($presetId);
            $shippingPerCountry = $preset->getShippingPerCountry();
        }

        //get product country / rate array
        //if preset values are not set, load product values
        if (!isset($shippingPerCountry)) {
            $shippingPerCountry = $_product->getMbShippingPerCountry();
        }

        $productrates = $this->getvaluearray($shippingPerCountry);

        //check if rate is defined for country
        if (array_key_exists($countryId, $productrates)) {
            $countryrate = $productrates[$countryId];

            //get default rate if rate is not defined
        } elseif (array_key_exists('-', $productrates)) {
            $countryrate = $productrates['-'];

            //get config value if no default rate is defined
        } else {
            $countryrate = $this->getDefaultCountryRate($countryId);
        }

        return $countryrate;
    }

    /**
     * @param $product
     * @return mixed
     */
    protected function _getConfigurableCalculation($product){
        $prntCalculation = $product->getMbConfigurableCalculation();
        if(!$prntCalculation){
            $prntCalculation = $this->getConfigData('mb_configurable_calculation');
        }
        return $prntCalculation;
    }

    /**
     * @param $item
     * @return bool|Mage_Catalog_Model_Product
     */
    protected function _getProduct($item,$allowParent = false){
        //configurable child
        if($item->getProduct()->getTypeId() !== 'configurable' && $prnt = $item->getParentItem()){

            //get parent / child calculation settings from parent
            $prnt = Mage::getModel('catalog/product')->load($prnt->getProduct()->getId());
            $prntCalculation = $this->_getConfigurableCalculation($prnt);

            //use parent product for calculation
            if($prntCalculation === "1"){
                return $prnt;

            //use child product for calculation
            }elseif($prntCalculation === "2"){
                //use child (current product) for calculation
                return Mage::getModel('catalog/product')->load($item->getProduct()->getId());
            }

        //configurable parent
        }elseif($item->getProduct()->getTypeId() == 'configurable'){
            $_product = Mage::getModel('catalog/product')->load($item->getProduct()->getId());
            $prntCalculation = $this->_getConfigurableCalculation($_product);
            if($prntCalculation === "2"){
                //use child product
                return false;
            }else{
                //use parent product
                return Mage::getModel('catalog/product')->load($item->getProduct()->getId());
            }

            //normal simple product without parent
        }elseif($item->getProduct()->getTypeId() !== 'configurable') {
            return Mage::getModel('catalog/product')->load($item->getProduct()->getId());
        }
    }

    /**
     * @param $item
     * @param $product
     * @param $items
     * @return bool
     */
    protected function _getQty($item,$product,$items){
        $sku = $product->getSku();
        $qty = $item->getQty();
        $origItem = $item;

        if($item->getParentItem()){
            $qty = $qty * $item->getParentItem()->getQty();
        }

        //check for sku override
        if($product->getMbSku()){
            $sku = $product->getMbSku();
        }

        //qty already added
        if(in_array($sku,$this->_skusProcessed)){
            return false;
        }

        $this->_skusProcessed[] = $sku;

        foreach($items as $item){
            if($item->getProduct()->getTypeId() == 'configurable'){
                continue;
            }

            if($item === $origItem){
                continue;
            }

            $iProduct = $this->_getProduct($item,true);
            if(!$iProduct){
                continue;
            }

            $iSku = $iProduct->getSku();
            //check for sku override
            if($iProduct->getMbSku()){
                $iSku = $iProduct->getMbSku();
            }
            if($iSku == $sku){
                $iQty = $item->getQty();
                if($item->getParentItem()){
                    $iQty = $iQty * $item->getParentItem()->getQty();
                }
                $qty += $iQty;
            }
        }

        return $qty;
    }

    /**
     * Add method to allowed methods
     *
     * @return array
     */

    public function getAllowedMethods()
    {
        return array($this->_code => $this->getConfigData('name'));
    }

}

