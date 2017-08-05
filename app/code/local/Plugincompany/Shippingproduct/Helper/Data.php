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
class Plugincompany_Shippingproduct_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Retrieve shipping rate for product for a specific country
     *
     * @param $_product
     * @param null $countryId
     * @return int|string
     */
    public function getShippingRate($_product, $countryId = null)
    {
        if (!$_product->getId()) {
            return 'Error retrieving shipping rate';
        }
        if (!$_product->getMbPresetId() || $_product->getMbShippingPerCountry()) {
            $_resource = $_product->getResource();
            $presetId = $_resource->getAttributeRawValue($_product->getId(), 'mb_preset_id', Mage::app()->getStore());
            $shippingRates = $_resource->getAttributeRawValue($_product->getId(), 'mb_shipping_per_country', Mage::app()->getStore());
            $_product->setMbPresetId($presetId);
            $_product->setMbShippingPerCountry($shippingRates);
        }
        return Mage::getModel('plugincompany_shippingproduct/carrier_shippingcountry')->getShippingRateForProduct($_product, $countryId);
    }
}
	 