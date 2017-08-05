<?php
/**
 *
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
 *
 */
class Plugincompany_Shippingproduct_Block_Preset_Grid extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
         $this->_blockGroup      = 'plugincompany_shippingproduct';
         $this->_controller      = 'preset_grid';
         $this->_headerText      = $this->__('Product Shipping Rate Preset Manager');
         $this->_addButtonLabel  = $this->__('Add New Preset');
         parent::__construct();
    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/*/new');
    }

}

