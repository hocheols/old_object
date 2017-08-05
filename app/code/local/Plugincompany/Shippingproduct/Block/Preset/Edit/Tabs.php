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
class Plugincompany_Shippingproduct_Block_Preset_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("pcshipping_preset_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("plugincompany_shippingproduct")->__("Preset Information"));
		}
		protected function _beforeToHtml()
		{
            $this->addTab("form_section", array(
            "label" => Mage::helper("plugincompany_shippingproduct")->__("Shipping Rate Settings"),
            "title" => Mage::helper("plugincompany_shippingproduct")->__("Shipping Rate Settings"),
            "content" => $this->getLayout()->createBlock("plugincompany_shippingproduct/preset_edit_tab_form")->toHtml(),
            ));

            $this->addTab("products_section", array(
                "label" => Mage::helper("plugincompany_shippingproduct")->__("Preset Products"),
                "title" => Mage::helper("plugincompany_shippingproduct")->__("Preset Products"),
                "content" => $this->getLayout()->createBlock("plugincompany_shippingproduct/preset_edit_tab_product")->toHtml(),
            ));

//            $this->addTab("conditions", array(
//                "label" => Mage::helper("groupswitch")->__("Rule Conditions"),
//                "title" => Mage::helper("groupswitch")->__("Rule Conditions"),
//                "content" => $this->getLayout()->createBlock("groupswitch/adminhtml_groupswitch_edit_tab_conditions")->toHtml(),
//            ));
//
//            $this->addTab("actions", array(
//                "label" => Mage::helper("groupswitch")->__("Rule Action"),
//                "title" => Mage::helper("groupswitch")->__("Rule Action"),
//                "content" => $this->getLayout()->createBlock("groupswitch/adminhtml_groupswitch_edit_tab_actions")->toHtml(),
//            ));
				return parent::_beforeToHtml();
		}

}
