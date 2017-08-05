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
 * Class Plugincompany_Shippingproduct_Model_Source_Override
 */
class Plugincompany_Shippingproduct_Model_Source_Override extends Mage_Eav_Model_Entity_Attribute_Source_Table
{
    /**
     * Options for product page
     *
     * @return array
     */
    public function getAllOptions()
    {
        return array(
                    array('label'=>'Use default config','value'=>0),
					array('label'=>'Add to total shipping costs','value'=>1),
					array('label'=>'Override total shipping costs','value'=>2),
					);
    }

    /**
     * Option array for config dropdown
     *
     * @return array
     */
    public function toOptionArray($showDefault = false)
    {
        $options = array();

        foreach ($this->getAllOptions() as $option) {
            //exclude use config value,
            //because optionarray is used for config
            if (!$showDefault) {
                if ($option['value'] == 0) {
                    continue;
                }

            }
            //add option
            $options[$option['value']] = $option['label'];
        }
        return $options;
    }
}
