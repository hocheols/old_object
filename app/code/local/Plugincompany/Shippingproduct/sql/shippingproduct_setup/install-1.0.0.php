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
$installer = $this;


$setId = Mage::getModel('catalog/product')->getDefaultAttributeSetId();
$installer->addAttributeGroup(Mage_Catalog_Model_Product::ENTITY, $setId, 'Product Shipping Rates', 1000);

$installer->installEntities();

?>