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
$installer = $this;
$installer->startSetup();

$installer->addAttribute('catalog_product', 'mb_configurable_calculation', array(         // TABLE.COLUMN:                                       DESCRIPTION:
    'group'				=> 'Product Shipping Rates',
    'label'             => 'Configurable Product Shipping Rates',
    'sort_order'        => 10000,
    'type'              => 'int',
    'default'           => '0',
    'class'             => '',
    'backend'           => 'eav/entity_attribute_backend_array',
    'frontend'          => '',
    'source'            => 'plugincompany_shippingproduct/source_configurablecalc',
    'input'				=> 'select',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'           => true,
    'required'          => false,
    'user_defined'      => false,
    'searchable'        => false,
    'filterable'        => false,
    'comparable'        => false,
    'visible_on_front'  => false,
    'visible_in_advanced_search' => false,
    'unique'            => false,
    'apply_to'          => 'configurable',
    'note'				=> 'Configure the shipping rates of configurable products based on the parent or the child product settings.',
));

$installer->updateAttribute('catalog_product', 'mb_configurable_calculation', 'apply_to', 'configurable');

$installer->addAttribute('catalog_product', 'mb_sku', array(         // TABLE.COLUMN:                                       DESCRIPTION:
    'group'				=> 'Product Shipping Rates',
    'label'             => 'Shipping Rate Calculation SKU',
    'sort_order'        => 10001,
    'type'              => 'text',
    'default'           => '',
    'class'             => '',
    'backend'           => '',
    'frontend'          => '',
    'source'            => '',
    'input'				=> 'text',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'           => true,
    'required'          => false,
    'user_defined'      => false,
    'searchable'        => false,
    'filterable'        => false,
    'comparable'        => false,
    'visible_on_front'  => false,
    'visible_in_advanced_search' => false,
    'unique'            => false,
    'note'				=> 'Products with the same shipping rate calculation SKU will be treated as one single product, which can be useful when configuring the shipping settings of similar products that are sold in different sizes, colors, etc.',
));


$installer->endSetup();
?>