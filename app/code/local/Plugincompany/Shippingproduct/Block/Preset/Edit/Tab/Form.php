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
class Plugincompany_Shippingproduct_Block_Preset_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('current_preset');

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset("preset_form", array("legend"=>Mage::helper("plugincompany_shippingproduct")->__("Shipping Rate Settings")));

        $fieldset->addField('title', 'text', array(
            'name' => 'title',
            'label' => Mage::helper('plugincompany_shippingproduct')->__('Preset Name'),
            'title' => Mage::helper('plugincompany_shippingproduct')->__('Preset Name'),
            'required' => true,
        ));

        $fieldset->addField('shipping_per_country', 'pcshipping', array(
            'name' => 'shipping_per_country',
            'label' => Mage::helper('plugincompany_shippingproduct')->__('Preset Shipping Rates'),
            'title' => Mage::helper('plugincompany_shippingproduct')->__('Preset Shipping Rates'),
            'required' => true,
        ));

        $fieldset->addField('in_preset_products', 'hidden', array(
            'name' => 'in_preset_products',
            'label' => Mage::helper('plugincompany_shippingproduct')->__('In Preset products'),
            'title' => Mage::helper('plugincompany_shippingproduct')->__('In Preset products'),
            'required' => false
        ));

        $fieldset->addField('per_item', 'select', array(
            'label'     => Mage::helper('plugincompany_shippingproduct')->__('Shipping Rate Calculation'),
            'title'     => Mage::helper('plugincompany_shippingproduct')->__('Shipping Rate Calculation'),
            'name'      => 'per_item',
            'required' => true,
            'options'   => Mage::getModel('plugincompany_shippingproduct/source_peritem')->toOptionArray(true)
        ));

        $fieldset->addField('override', 'select', array(
            'label'     => Mage::helper('plugincompany_shippingproduct')->__('Total Shipping Cost Calculation'),
            'title'     => Mage::helper('plugincompany_shippingproduct')->__('Total Shipping Cost Calculation'),
            'name'      => 'override',
            'required' => true,
            'options'   => Mage::getModel('plugincompany_shippingproduct/source_override')->toOptionArray(true)
        ));

        if($model){
            $form->setValues($model->getData());
        }
        return parent::_prepareForm();
    }

}
