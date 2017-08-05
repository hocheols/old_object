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

//Add values to table widget based on input
function addshippingvaluesFee(){
var pcshippingFeeForm = new varienForm('plugfixed',true);
			jQuery('#mb_fixedprice').addClass('required-entry');
			if (pcshippingFeeForm.validator.validate() && jQuery('#mb_fixedcountry').val() != 0) {
                jQuery('#mb_fixedcountry option:selected').each(function() {
					if(jQuery(this).val() == "0"){
						return;
					}
                    jQuery('#mb_fixedshippingtable tbody').append('<tr><td style="text-align:center">'+jQuery(this).val()+'</td><td>'+jQuery(this).text()+'</td><td style="text-align:right">'+parseFloat(jQuery('#mb_fixedprice').val().replace(',','.')).toFixed(2)+'</td><td><button title="Delete row" type="button" class="scalable delete icon-btn delete-product-option mb_fixeddelete" onclick="mb_fixeddeletitemFee(this)"><span><span><span>Delete</span></span></span></button></td></tr>');
                    jQuery('.mb_fixed_shipping_per_country').val((jQuery('.mb_fixed_shipping_per_country').val()+';'+jQuery(this).val()+':'+parseFloat(jQuery('#mb_fixedprice').val().replace(',','.')).toFixed(2)+';').replace(';;',';'));
                })
				jQuery('#mb_fixedprice').val('');
			}
			jQuery('#mb_fixedprice').removeClass('required-entry');
			checkoptionsFee();
}
		
//Delete row from table widget
function mb_fixeddeletitemFee(row){
	var mb_fixedval = jQuery(row).parent().siblings('td');
	var mb_fixedcountry = mb_fixedval.eq(0).text();
	var mb_fixedprice = mb_fixedval.eq(2).text();
	var mb_fixedstring = mb_fixedcountry+':'+mb_fixedprice;
	var nieuwval = jQuery('.mb_fixed_shipping_per_country').val().replace(mb_fixedstring,'').replace(';;',';');
	jQuery('.mb_fixed_shipping_per_country').val(nieuwval);
	jQuery(row).parent().parent().remove();
	checkoptionsFee();
}

//Hides country options that are already added
function checkoptionsFee(){
	jQuery('#mb_fixedcountry option').each(function(){
		var searchstring = jQuery('.mb_fixed_shipping_per_country').val();
		var thisval = jQuery(this).val();
		if(searchstring.search(thisval) != '-1' && thisval != 0){
			jQuery(this).hide();
			}else{
			jQuery(this).show();
			}
		});
		jQuery('#mb_fixedcountry option').attr('selected',false);
		jQuery('#mb_fixedzero').attr('selected',true);
}

//key input hook and options initialize
jQuery(document).ready(function(){
	jQuery('#mb_fixedprice').keyup(function(e) {
		if(e.keyCode == 13) {
			addshippingvaluesFee();
		}
	});
	checkoptionsFee();
    addRegionButtonsFee();

})

//add region select buttons
function addRegionButtonsFee() {
    jQuery.each(pcregions,function(k,v) {
        var title = k.replace(/([a-z])([A-Z])/g, '$1 $2');
        var button = '<button style="margin:3px;width:110px" type="button" onclick="selectRegionFee(\'' + k + '\')"><span>' + title.capitalize() + '</span></button>';
        jQuery(button).appendTo('#pc_fixedregions');
    })
}

//select region countries
function selectRegionFee(region) {
    var reg = pcregions[region];
    jQuery('#mb_fixedcountry option').prop('selected', false);
    jQuery.each(reg.countries,function(k,v) {
        jQuery('#mb_fixedcountry option[value="' + v + '"]').prop('selected', true);
    })
}

