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
 * Form element class for country / rate input
 *
 * Class Varien_Data_Form_Element_Mbshipping
 */
class Varien_Data_Form_Element_Pcshipping extends Varien_Data_Form_Element_Abstract
{
    /**
     * @param array $attributes
     */
    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
        $this->setType('text');
        $this->setExtType('textfield');
		Mage::app()->getLayout()->getBlock('head')->addJs('plugincompany/jquerynoconflict.js');
		Mage::app()->getLayout()->getBlock('head')->addJs('plugincompany/shippingcountry.js');
    }

    /**
     * @return mixed|string
     */
    public function getHtml()
    {
        $this->addClass('input-text');
        return parent::getHtml();
    }

    /**
     * @return array
     */
    public function getHtmlAttributes()
    {
        return array('type', 'title', 'class', 'style', 'onclick', 'onchange', 'onkeyup', 'disabled', 'readonly', 'maxlength', 'tabindex');
    }

    /**
     * Hidden field with actual values
     *
     * @return string
     */
    public function getElementHtml()
    {
        $html = '<input style="display:none;" class="mb_shipping_per_country" id="'.$this->getHtmlId().'" name="'.$this->getName()
             .'" value="'.$this->getEscapedValue().'" '.$this->serialize($this->getHtmlAttributes()).'/>'."\n";
		$html .= $this->getdatatable();
        $html .= $this->getAfterElementHtml();
        $html .= $this->getScripts();
        return $html;
    }

    /**
     * The input widget
     *
     * @return string
     */
    public function getAfterElementHtml()
    {
        $html = '<div class="entry-edit-head" style="width:439px;background:#83a9c4;margin-top:4px;"><h4>Add Country Specific Shipping Rates</h4></div>';
		$html .= '<div id="plugship" name="plugship" style="padding:4px;background:#d7e5ef;width:452px;height:220px;">';
		$html .= $this->getdropdown();
        $html .= '<div id="pcregions"><p><b>Select a region:</b></p></div>';
		$html .= '<input id="mbprice" style="margin-right:4px" class="validate-zero-or-greater" /><button style="margin-top:10px" type="button" onClick="addshippingvalues();">Add</button></div>';
        $html .= parent::getAfterElementHtml();
        return $html;
    }

    /**
     * Countries dropdown
     *
     * @return string
     */
    public function getdropdown(){
		$_countries = Mage::getResourceModel('directory/country_collection')
					->loadByStore()                                  
					->toOptionArray(false);	
		if (count($_countries) > 0): 
			$html = '<select multiple style="width:200px;float:left;margin:4px;height:212px;" name="country" id="mbcountry">
						<option id="mbzero" value="0">-- Please Select --</option>
						<option value="-">Default rate</option>';
		   foreach($_countries as $_country):
					$html .= '<option value="'.$_country['value'].'">'.$_country['label'].'</option>';
			endforeach;
			$html .= '</select>';
		endif;
		
		return $html;
	
	}

    /**
     * Unserialize string from input
     *
     * @return array|bool|string
     */
    public function getvaluearray(){
		$values = $this->getEscapedValue();
		$values = trim($values,'; ');
        $values = explode(';',$values);
        foreach($values as $k=>$v){
            $values[$k] = explode(':',$v);
        }
        asort($values);
        return $values;
	}

    /**
     * Table with current values
     *
     * @return string
     */
    public function getdatatable(){
		$html = "<span class='grid'><table id='mbshippingtable' cellspacing='0' style='width:460px' class='data border'>";
		$html .= "<thead><tr class='headings'><th style='width:20px'>Code</th><th>Country</th><th style='width:40px;text-align:right;'>Shipping Rate</th><th style='width:30px'></th></tr></thead><tbody>";
		foreach ($this->getvaluearray() as $v){
            if (!$v[0]) {
                continue;
            }
			if($v[0] == '-'){$standard = 'Default rate';}else{$standard = '';}
			$html .= "<tr class='mbshipping ".$v[0]."'><td style='text-align:center'>".$v[0]."</td><td>".Mage::app()->getLocale()->getCountryTranslation($v[0]).$standard."</td><td style='text-align:right'>".$v[1]."</td><td><button title='Delete row' type='button' class='scalable delete icon-btn delete-product-option mbdelete' onclick='mbdeletitem(this)'><span><span><span>Delete</span></span></span></button></td></tr>";
		
		}
		$html .= "</tbody></table></span>";
		return $html;
	
	}
    public function getEscapedValue($index=null)
    {
        $value = $this->getValue($index);

        if ($product = Mage::registry('current_product')) {
            if ($pId = $product->getMbPresetId()) {
                $value = Mage::getModel('plugincompany_shippingproduct/preset')->load($pId)->getShippingPerCountry();
            }
        }

        if ($filter = $this->getValueFilter()) {
            $value = $filter->filter($value);
        }

        if ($value == '0' || $value == '0;' || $value == ';') {
            return '';
        }
        $value = preg_replace("/^\d+;/","",$value);
        $value = preg_replace("/;\d+;/","",$value);
        return $this->_escape($value);
    }

    public function getScripts()
    {
        if ($product = Mage::registry('current_product')) {
            if ($pId = $product->getMbPresetId()) {
                $preset = Mage::getModel('plugincompany_shippingproduct/preset')->load($pId);
                $perItem = $preset->getPerItem();
                $override = $preset->getOverride();
                $script = "
                    <script type='text/javascript'>
                    jQuery(document).ready(function(){
                        jQuery('#mb_per_item').val($perItem);
                        jQuery('#mb_override').val($override);
                    })
                    </script>
                ";
                return $script;
            }
        }
    }
}


