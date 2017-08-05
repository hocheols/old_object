<?php

class ModulebazaarLicence {

    private static $connection;
    private static $dbname;
    private static $sku;
    private static $frontendDays = 14;
    private static $backendDays = 7;
    private static $applyTo;

    /**
     * 
     * @param type $data
     */
    private static function connect($data) {
        self::$dbname = $data['dbname'];
        self::$connection = mysql_connect($data['host'], $data['username'], $data['password']);
        if (!self::$connection) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db($data['dbname']);
    }
    
    /**
     * @param type $data
     * @data @param sku => Modulebazaar product SKU
     * @data @param applyTo => Either frontend or backend
     * @data @param dbname => Database name
     * @data @param host => Database server
     * @data @param username => Database username
     * @data @param password => Database password
     * @return array
     */
    public static function checkLicence($data) {
        $sku = $data['sku']; // Sku of the module in the modulebazaar.com
        $applyTo = $data['applyTo']; // whether this checking for frontend or backend
        $keyhash = 'AS8sIcUjbgAS8sIcUjbgAS8sIcUjbfuv'; // This key is used for encryption
        $allow = array();
        $allow['status'] = 0;
        $shopdomain = htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8'); // Current domain
	// || $_SERVER['HTTP_HOST'] == '192.168.1.118'
        if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1')
	{ // Allow the extension for local development
            $allow['status'] = 1;
            return $allow;
        }
	
        self::connect($data); // Connection to the database
        if (!self::createLogTable()) {
            return $allow;
        }
	
        // Getting the serial for the given sku from local database
        $result = mysql_query("select serial,sku from modulebazaar_licence where sku = '" . $sku . "'", self::$connection);
        $row = mysql_fetch_row($result);
        $serial = $row[0];
        /**
         * If serial is empty, check the licence in dropshipmodule.com using cURL. If response is not error, 
         * generate the serial and save it in local database.
         */
        if (empty($serial))
	{
            $response = self::setcURLrequest($shopdomain, $sku);

            if ($response == 'error') { // If response is error, don't allow extension
                return $allow;
            }

            $p_res = json_decode($response);

            $r_status = strtolower($p_res->status);
            $r_domain = $p_res->domain;
        
            // Encryption for the serial
            $encrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $keyhash, $r_domain . '_' . $r_status . '_' . date('Ymd'), MCRYPT_MODE_ECB); 
            $encrypt = base64_encode($encrypt); // Encoding for the serial

            // Insert the serial and sku in the DB
            if (!mysql_query("insert into modulebazaar_licence(serial,sku) values ('" . $encrypt . "','" . $sku . "')", self::$connection))
	    { 
                return $allow;
            }

            // If domain is valid and status is active, allow the extension
             $domain1 = str_replace("www.","",$shopdomain); 
            $domain2 = 'www.'.$domain1;
			
            if (($r_domain==$domain1 || $r_domain==$domain2) && (strtolower($r_status)=='active'))
            {
                $allow['status'] = 1;
                return $allow;
            }
            return $allow;
        }
	else
	{
            $encrypted = base64_decode($serial); // Decoding the serial
            $decrypt = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $keyhash, $encrypted, MCRYPT_MODE_ECB); // Decrypt the serial
            $decrypted = explode("_", $decrypt);
            $domain = isset($decrypted[0]) ? trim($decrypted[0]) : ''; // Domain in the saved serial
            $status = isset($decrypted[1]) ? trim($decrypted[1]) : ''; // Status in the saved serial
            $backendDate = isset($decrypted[2]) ? trim($decrypted[2]) : ''; // Backend date in the saved serial
            $frontendDate = isset($decrypted[3]) ? trim($decrypted[3]) : ''; // Frontend date in the saved serial
            
            $domain1 = str_replace("www.","",$shopdomain); 
            $domain2 = 'www.'.$domain1;
            
            $domainChanges = false;
            if($domain != $domain1)
            {
                if($domain != $domain2)
                {
                    $domainChanges = true;
                }						
            }

            if ((!self::checkDate($frontendDate, $backendDate)) || ((strtolower($status) != 'active') && (strtolower($status) != 'inactive')) || $domainChanges) {
                // Call to dropshipmodule.com
                $response = self::setcURLrequest($shopdomain, $sku); 
                if ($response == 'error') {
                    return $allow;
                }
                $p_res = json_decode($response);
                $r_status = strtolower($p_res->status);
                $r_domain = $p_res->domain;
                if ($applyTo == 'backend')
		{
                    // Reset the backend date but not frontend date
                    $encrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $keyhash, $r_domain . '_' . $r_status . '_' . date('Ymd') . '_' . $frontendDate, MCRYPT_MODE_ECB);
                }
		else
		{
                    // Reset the both dates
                    $encrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $keyhash, $r_domain . '_' . $r_status . '_' . date('Ymd') . '_' . date('Ymd'), MCRYPT_MODE_ECB);
                }
                $encrypt = base64_encode($encrypt);
                // Update the serial in the local database
                if (!mysql_query("update modulebazaar_licence set serial='" . $encrypt . "' where sku='".$sku."'", self::$connection))
		{
                    return $allow;
                }
                
                 // If domain is valid and status is active, allow the extension
                $domain1 = str_replace("www.","",$shopdomain); 
                $domain2 = 'www.'.$domain1;
                            
                if (($r_domain==$domain1 || $r_domain==$domain2) && (strtolower($r_status)=='active'))
                {
                    $allow['status'] = 1;
                    return $allow;
                }
                return $allow;
                // If date is not valid and status is inactive, don't allow the extension
            } elseif ((!self::checkDate($frontendDate, $backendDate, $applyTo)) && ($status == 'inactive')) { 
                $allow['status'] = 0;
                return $allow;
                // If date is valid and status is active, allow the extension
            } elseif ((self::checkDate($frontendDate, $backendDate, $applyTo)) && ($status == 'active')) {
                $allow['status'] = 1;
                return $allow;
            }
        }
    }
    
    /**
     * 
     * @param type $frontendDate
     * @param type $backendDate
     * @return boolean
     */
    private static function checkDate($frontendDate, $backendDate, $applyTo='backend')
    {
        if ($applyTo == 'backend' && self::$backendDays >= self::getDiffDays($backendDate))
	{
            return TRUE;
        }
	elseif ($applyTo == 'frontend' && self::$frontendDays >= self::getDiffDays($frontendDate))
	{
            return TRUE;
        }
	else
	{
            return FALSE;
        }
    }
    
    /**
     * 
     * @param type $encDate
     * @return type
     */
    private static function getDiffDays($encDate) {
        $currentDate = date_create(date('Ymd'));
        $encDate1 = date_create($encDate);
        $diff = date_diff($encDate1, $currentDate);
        return $diff->format("%R%a");
    }
    
    /**
     * 
     * @return boolean
     */
    private static function createLogTable() {
        if (self::isTableExists()) { // If table exists, return true
            return true;
        } else { // Create a new table in the satabase if not exist
            return mysql_query('CREATE TABLE IF NOT EXISTS `modulebazaar_licence` (`serial` BLOB,`sku` TEXT)', self::$connection);
        }
    }
    
    /**
     * 
     * @return boolean
     */
    public static function isTableExists() {
        $dbname = self::$dbname;
        $result = mysql_query("show tables from {$dbname}");
        while ($table = mysql_fetch_array($result)) {
            if ($table[0] == 'modulebazaar_licence') {
                return TRUE;
            }
        }
        return false;
    }
    
    /**
     * 
     * @param type $domain
     * @return string
     */
    private static function setcURLrequest($domain, $sku) {

        $url = 'http://www.dropshipmodule.com/user-license-validation.php';
        $nvpString = "domain=$domain&module=$sku";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpString);
        $httpResponse = curl_exec($ch);

        if (!$httpResponse) {
            return 'error';
        } else {
            return $httpResponse;
        }
    }
    
    /**
     * 
     * @param type $allow
     * @return string
     */
    public static function getLicenseMessage($allow) {
        // Not valid licence message
        if ($allow['status'] == 0) {
            return '<span align="center" style="color:red">
                    <strong>
                    This domain is not authorized to use this module.
                    <strong>
                    </span>
                    <br/>
                    Contact us at
                    <a href="http://www.modulebazaar.com" target="_blank">
                            <strong>www.modulebazaar.com</strong>
                    </a>';
        }
    }

    /*
     * * End License Authentication Functions
     */
}
