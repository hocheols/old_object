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
function addshippingvalues(){
var pcshippingForm = new varienForm('plugship',true);
			jQuery('#mbprice').addClass('required-entry');
			if (pcshippingForm.validator.validate() && jQuery('#mbcountry').val() != 0) {
                jQuery('#mbcountry option:selected').each(function() {
                    if(jQuery(this).val() == "0"){
                        return;
                    }
                    jQuery('#mbshippingtable tbody').append('<tr><td style="text-align:center">'+jQuery(this).val()+'</td><td>'+jQuery(this).text()+'</td><td style="text-align:right">'+parseFloat(jQuery('#mbprice').val().replace(',','.')).toFixed(2)+'</td><td><button title="Delete row" type="button" class="scalable delete icon-btn delete-product-option mbdelete" onclick="mbdeletitem(this)"><span><span><span>Delete</span></span></span></button></td></tr>');
                    jQuery('.mb_shipping_per_country').val((jQuery('.mb_shipping_per_country').val()+';'+jQuery(this).val()+':'+parseFloat(jQuery('#mbprice').val().replace(',','.')).toFixed(2)+';').replace(';;',';'));
                })
				jQuery('#mbprice').val('');
			}
			jQuery('#mbprice').removeClass('required-entry');
			checkoptions();
}
		
//Delete row from table widget
function mbdeletitem(row){
	var mbval = jQuery(row).parent().siblings('td');
	var mbcountry = mbval.eq(0).text();
	var mbprice = mbval.eq(2).text();
	var mbstring = mbcountry+':'+mbprice;
	var nieuwval = jQuery('.mb_shipping_per_country').val().replace(mbstring,'').replace(';;',';');
	jQuery('.mb_shipping_per_country').val(nieuwval);
	jQuery(row).parent().parent().remove();
	checkoptions();
}

//Hides country options that are already added
function checkoptions(){
	jQuery('#mbcountry option').each(function(){
		var searchstring = jQuery('.mb_shipping_per_country').val();
		var thisval = jQuery(this).val();
		if(searchstring.search(thisval) != '-1' && thisval != 0){
			jQuery(this).hide();
			}else{
			jQuery(this).show();
			}
		});
		jQuery('#mbcountry option').attr('selected',false);
		jQuery('#mbzero').attr('selected',true);
}

//key input hook and options initialize
jQuery(document).ready(function(){
	jQuery('#mbprice').keyup(function(e) {
		if(e.keyCode == 13) {
			addshippingvalues();
		}
	});
	checkoptions();
    addRegionButtons();

})

//add region select buttons
function addRegionButtons() {
    jQuery.each(pcregions,function(k,v) {
        var title = k.replace(/([a-z])([A-Z])/g, '$1 $2');
        var button = '<button style="margin:3px;width:110px" type="button" onclick="selectRegion(\'' + k + '\')"><span>' + title.capitalize() + '</span></button>';
        jQuery(button).appendTo('#pcregions');
    })
}

//select region countries
function selectRegion(region) {
    var reg = pcregions[region];
    jQuery('#mbcountry option').prop('selected', false);
    jQuery.each(reg.countries,function(k,v) {
        jQuery('#mbcountry option[value="' + v + '"]').prop('selected', true);
    })
}

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

var pcregions = {};

pcregions.europe = {
    countries: [
        // source is http://en.wikipedia.org/wiki/Europe
        'AL', // Albania
        'AD', // Andorra
        'AM', // Armenia
        'AT', // Austria
        'AZ', // Azerbaijan
        'BY', // Belarus
        'BE', // Belgium
        'BA', // Bosnia and Herzegovina
        'BG', // Bulgaria
        'HR', // Croatia
        'CY', // Cyprus
        'CZ', // Czech Republic
        'DK', // Denmark
        'EE', // Estonia
        'FI', // Finland
        'FR', // France
        'GE', // Georgia (country)
        'DE', // Germany
        'GR', // Greece
        'HU', // Hungary
        'IS', // Iceland
        'IE', // Republic of Ireland
        'IT', // Italy
        'KZ', // Kazakhstan
        'LV', // Latvia
        'LI', // Liechtenstein
        'LT', // Lithuania
        'LU', // Luxembourg
        'MK', // Republic of Macedonia
        'MT', // Malta
        'MD', // Moldova
        'MC', // Monaco
        'ME', // Montenegro
        'NL', // Netherlands
        'NO', // Norway
        'PL', // Poland
        'PT', // Portugal
        'RO', // Romania
        'RU', // Russia
        'SM', // San Marino
        'RS', // Serbia
        'SK', // Slovakia
        'SI', // Slovenia
        'ES', // Spain
        'SE', // Sweden
        'CH', // Switzerland
        'TR', // Turkey
        'UA', // Ukraine
        'GB', // United Kingdom
        'VA', // Vatican City

        // Several dependencies and similar territories with broad autonomy are also found in Europe. Note that the list does not include the constituent countries of the United Kingdom, federal states of Germany and Austria, and autonomous territories of Spain and the post-Soviet republics as well as the republic of Serbia.
        // Åland (Finland)
        'FO', // Faroe Islands (Denmark)
        'GI', // Gibraltar (UK)
        'GG', // Guernsey (UK)
        'IM', // Isle of Man (UK)
        'JE', // Jersey (UK)
        'SJ' // Svalbard and Jan Mayen (Norway)
    ]
};

pcregions.europeanUnion = {
    countries: [
        'BE',
        'BG',
        'CZ',
        'DK',
        'DE',
        'EE',
        'IE',
        'EL',
        'ES',
        'FR',
        'HR',
        'IT',
        'CY',
        'LV',
        'LT',
        'LU',
        'HU',
        'MT',
        'NL',
        'AT',
        'PL',
        'PT',
        'RO',
        'SI',
        'SK',
        'FI',
        'SE',
        'UK'
    ]
}

pcregions.middleEast = {
    countries: [
        // source is http://en.wikipedia.org/wiki/Middle_east
        'BH', // Bahrain
        'CY', // Cyprus
        'EG', // Egypt
        'IR', // Iran
        'IQ', // Iraq
        'IL', // Israel
        'JO', // Jordan
        'KW', // Kuwait
        'LB', // Lebanon
        'OM', // Oman
        'PS', // Palestine
        'QA', // Qatar
        'SA', // Saudi Arabia
        'SY', // Syria
        'TR', // Turkey
        'AE', // United Arab Emirates
        'YE' // Yemen
    ]
};

pcregions.latinAmerica = {
    countries: [
        // source is http://en.wikipedia.org/wiki/Latin_America
        'AR', // Argentina
        'BO', // Bolivia
        'BR', // Brazil
        'CL', // Chile
        'CO', // Colombia
        'CR', // Costa Rica
        'CU', // Cuba
        'DO', // Dominican Republic
        'EC', // Ecuador
        'SV', // El Salvador
        'GT', // Guatemala
        'HT', // Haiti
        'HN', // Honduras
        'MX', // Mexico
        'NI', // Nicaragua
        'PA', // Panama
        'PY', // Paraguay
        'PE', // Peru
        'PR', // Puerto Rico
        'UY', // Uruguay
        'VE' // Venezuela
    ]
};

pcregions.southAmerica = {
    countries: [
        // source is http://en.wikipedia.org/wiki/South_America
        'AR', // Argentina
        'BO', // Bolivia
        'BR', // Brazil
        'CL', // Chile
        'CO', // Colombia
        'EC', // Ecuador
        'FK', // Falkland Islands (United Kingdom)
        'GF', // French Guiana (France)
        'GY', // Guyana
        'PY', // Paraguay
        'PE', // Peru
        'GS', // South Georgia and the South Sandwich Islands
        'SR', // Suriname
        'TT', // Trinidad and Tobago
        'UY', // Uruguay
        'VE' // Venezuela
    ]
};

pcregions.easternAfrica = {
    countries: [
        // source is http://en.wikipedia.org/wiki/Africa
        'BI', // Burundi
        'KM', // Comoros
        'DJ', // Djibouti
        'ER', // Eritrea
        'ET', // Ethiopia
        'KE', // Kenya
        'MG', // Madagascar
        'MW', // Malawi
        'MU', // Mauritius
        'YT', // Mayotte (France)
        'MZ', // Mozambique
        'RE', // Réunion (France)
        'RW', // Rwanda
        'SC', // Seychelles
        'SO', // Somalia
        'SS', // South Sudan
        'TZ', // Tanzania
        'UG', // Uganda
        'ZM', // Zambia
        'ZW' // Zimbabwe
    ]
};

pcregions.centralAfrica = {
    countries: [
        // source is http://en.wikipedia.org/wiki/Africa
        'AO', // Angola
        'CM', // Cameroon
        'CF', // Central African Republic
        'TD', // Chad
        'CG', // Republic of the Congo
        'CD', // Democratic Republic of the Congo
        'GQ', // Equatorial Guinea
        'GA', // Gabon
        'ST' // São Tomé and Príncipe
    ]
};

pcregions.northernAfrica = {
    countries: [
        // source is http://en.wikipedia.org/wiki/Africa
        'DZ', // Algeria
        'IC', // Canary Islands (Spain)
        // Santa Cruz de Tenerife
        'EA', // Ceuta (Spain)
        'EG', // Egypt
        'LY', // Libya
        // Madeira (Portugal)
        // Melilla (Spain)
        'MA', // Morocco
        'SD', // Sudan
        'TN', // Tunisia
        'EH' // Western Sahara
    ]
};

pcregions.southernAfrica = {
    countries: [
        // source is http://en.wikipedia.org/wiki/Africa
        'BW', // Botswana
        'LS', // Lesotho
        'NA', // Namibia
        'ZA', // South Africa
        'SZ' // Swaziland
    ]
};

pcregions.westernAfrica = {
    countries: [
        // source is http://en.wikipedia.org/wiki/Africa
        'BJ', // Benin
        'BF', // Burkina Faso
        'CV', // Cape Verde
        'CI', // Côte d'Ivoire
        'GM', // Gambia
        'GH', // Ghana
        'GN', // Guinea
        'GW', // Guinea-Bissau
        'LR', // Liberia
        'ML', // Mali
        'MR', // Mauritania
        'NE', // Niger
        'NG', // Nigeria
        'SH', // Saint Helena, Ascension and Tristan da Cunha (United Kingdom)
        'SN', // Senegal
        'SL', // Sierra Leone
        'TG' // Togo
    ]
};


pcregions.asia = {
    countries: [
        // source is http://en.wikipedia.org/wiki/Asia
        'AF', // Afghanistan
        'AM', // Armenia
        'AZ', // Azerbaijan
        'BH', // Bahrain
        'BD', // Bangladesh
        'BT', // Bhutan
        'BN', // Brunei
        'KH', // Cambodia
        'CN', // China
        'CY', // Cyprus
        'TL', // East Timor
        'GE', // Georgia (country)
        'IN', // India
        'ID', // Indonesia
        'IR', // Iran
        'IQ', // Iraq
        'IR', // Israel
        'JP', // Japan
        'JO', // Jordan
        'KZ', // Kazakhstan
        'KW', // Kuwait
        'KG', // Kyrgyzstan
        'LA', // Laos
        'LB', // Lebanon
        'MY', // Malaysia
        'BV', // Maldives
        'MN', // Mongolia
        'MM', // Myanmar (Burma)
        'NP', // Nepal
        'KP', // North Korea
        'OM', // Oman
        'PK', // Pakistan
        'PS', // Palestinian territories
        'PH', // Philippines
        'QA', // Qatar
        'RU', // Russia
        'SA', // Saudi Arabia
        'SG', // Singapore
        'LK', // Sri Lanka
        'KR', // South Korea
        'SY', // Syria
        'TW', // Taiwan
        'TJ', // Tajikistan
        'TH', // Thailand
        'TR', // Turkey
        'TM', // Turkmenistan
        'AE', // United Arab Emirates
        'UZ', // Uzbekistan
        'VN', // Vietnam
        'YE' // Yemen
    ]
};
/*
pcregions.caribbean = {
    countries: [
        // source is http://www.infoplease.com/ipa/A0877690.html
        'AI', // Anguilla
        'AG', // Antigua and Barbuda
        'BS', // Bahamas
        'BB', // Barbados
        'BM', // Bermuda
        'VG', // British Virgin Islands
        'KY', // Cayman Islands
        'DO', // Dominican Republic
        'DM', // Dominica
        'GD', // Grenada
        'JM', // Jamaica
        'MS', // Montserrat
        'KN', // St. Kitts & Nevis
        'LC', // St. Lucia
        'VC', // St. Vincent & the Grenadines
        'TT', // Trinidad & Tobago
        'TC' // Turks & Caicos
    ]
};
*/

pcregions.pacificIslands = {
    countries: [
        // source is http://data.worldbank.org/region/PSS
        'FJ', // Fiji
        'KI', // Kiribati
        'MH', // Marshall Islands
        'FM', // Micronesia, Fed. Sts.
        'PW', // Palau
        'WS', // Samoa
        'SB', // Solomon Islands
        'TO', // Tonga
        'TV', // Tuvalu
        'VU' // Vanuatu
    ]
};



