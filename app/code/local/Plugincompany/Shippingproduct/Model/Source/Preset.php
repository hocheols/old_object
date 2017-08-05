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
 * Class Plugincompany_Shippingproduct_Model_Source_Peritem
 */
class Plugincompany_Shippingproduct_Model_Source_Preset extends Mage_Eav_Model_Entity_Attribute_Source_Table
{
    /**
     * Options for product page
     *
     * @return array
     */
    public function getAllOptions()
    {

        $options = Mage::getModel('plugincompany_shippingproduct/preset')->getCollection()->toOptionArray();

        return $options;
    }

    /**
     * Option array for config dropdown
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = Mage::getModel('plugincompany_shippingproduct/preset')->getCollection()->toOptionHash();

        $options[0] = "Don't use a preset";

        return $options;
    }
}
