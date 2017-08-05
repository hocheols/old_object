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

class Plugincompany_Shippingproduct_Model_Resource_Eav_Mysql4_Setup extends Mage_Eav_Model_Entity_Setup
{

    /**
     * Returns product attributes for installer
     *
     * @return array
     */
    public function getDefaultEntities()
    {
        return array(
            'catalog_product' => array(
                'entity_model'      => 'catalog/product',
                'attribute_model'   => 'catalog/resource_eav_attribute',
                'table'             => 'catalog/product',
				'additional_attribute_table' => 'catalog/eav_attribute',
                'entity_attribute_collection' => 'catalog/product_attribute_collection',
                'attributes'        => array(
                    'mb_shipping_per_country' => array(
						'group'				=> 'Product Shipping Rates',
                        'label'             => 'Product Shipping Rates Per Country',
                        'type'              => 'text',
                        'input'             => 'pcshipping',
                        'default'           => '0',
                        'class'             => '',
                        'backend'           => '',
                        'frontend'          => '',
                        'source'            => '',
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
                        'note'              => 'The country-specific shipping rates specified here will overwrite the default configuration.'
                    ),
					'mb_per_item' => array(
						'group'				=> 'Product Shipping Rates',
                        'label'             => 'Product Shipping Rate Calculation',
                        'type'              => 'int',
                        'default'           => '0',
                        'class'             => '',
                        'backend'           => 'eav/entity_attribute_backend_array',
                        'frontend'          => '',
                        'source'            => 'plugincompany_shippingproduct/source_peritem',
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
						'note'				=> '<b>Per item:</b> Product shipping rate is multiplied with the ordered quantity.<br/><b>Per product/SKU:</b> Product shipping rate is charged once, regardless of the ordered quantity.',
                    ),
					
					'mb_override' => array(
						'group'				=> 'Product Shipping Rates',
                        'label'             => 'Total Shipping Costs Calculation',
                        'type'              => 'int',
                        'default'           => '0',
                        'class'             => '',
						'backend'           => 'eav/entity_attribute_backend_array',
                        'frontend'          => '',
                        'source'            => 'plugincompany_shippingproduct/source_override',
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
						'note'				=> '<b>Add to total shipping costs:</b> Product shipping rate is added to the total shipping costs. <br /><b>Override total shipping costs:</b> Product shipping rate overrides the total shipping costs.',
                    ),
               )
           ),

      );
}

}