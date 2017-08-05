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
$table = $installer->getTable('plugincompany_shippingproduct/preset');
$sql="
drop table if exists {$table};
create table {$table}(
    preset_id int not null auto_increment,
    title varchar(255),
    per_item int(10),
    override int(10),
    shipping_per_country text,
    primary key(preset_id)
);
";

$installer->run($sql);

$installer->addAttribute('catalog_product', 'mb_preset_id', array(         // TABLE.COLUMN:                                       DESCRIPTION:
    'group'				=> 'Product Shipping Rates',
    'label'             => 'Use Preset',
    'sort_order'        => -1,
    'type'              => 'int',
    'default'           => '0',
    'class'             => '',
    'backend'           => 'eav/entity_attribute_backend_array',
    'frontend'          => '',
    'source'            => 'plugincompany_shippingproduct/source_preset',
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
    'note'				=> 'Selected presets will take effect after saving the product. Alternatively, product shipping rates can be configured manually below.',
));


$installer->endSetup();
?>