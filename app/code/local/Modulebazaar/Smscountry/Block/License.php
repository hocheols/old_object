<?php
$libPath = Mage::getBaseDir('lib').DS.'ModulebazaarLicence.php';
$moduleName = 'Smscountry';
$moduleLibPath = Mage::getBaseDir('code').DS.'local'.DS.'Modulebazaar'.DS.$moduleName.DS.'lib'.DS.'ModulebazaarLicence.php';
if(!file_exists($libPath))
{
    copy($moduleLibPath, $libPath);
}
include_once($libPath);

class Modulebazaar_Smscountry_Block_License extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $data = Mage::helper('smscountry')->getCrendetials();
        $allow = ModulebazaarLicence::checkLicence($data);
        $licenseCheckUrl = Mage::getBaseUrl().'smscountry/index/licence/';
        $html = "";
        
        $validHtml = '<span style="color:green" align="center"><strong>This domain is authorized to use this module now.</strong></span>';
        
        if($allow['status'] == 1)
        {
            $html .= $validHtml;
        }
        else
        {
            $html .= '<span id="invalid-container">';
            $html .= ModulebazaarLicence::getLicenseMessage($allow, 'admin');
            $html .= '<button style="margin-top:10px" onclick="checkLicense()" class="scalable save" type="button" title="Check License">
            <span><span><span>Check License</span></span></span></button>
            </span>
            <script>
            function checkLicense()
            {
        
                new Ajax.Request("'.$licenseCheckUrl.'", {
                    onSuccess: function(response) {
                        if (200 == response.status)
                        {
                            if(response.responseText == 1)
                            {
                                document.getElementById("invalid-container").innerHTML = \''.$validHtml.'\';
                            }
                        }
                    }
                });
            }
            </script>';
        }
        return $html;
    }
}
