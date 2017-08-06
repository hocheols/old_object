<?php

class FME_Geoipdefaultlanguage_Adminhtml_ImportgeotablesController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('geoipdefaultlanguage/items')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Group Manager'), Mage::helper('adminhtml')->__('Group Manager'));

        return $this;
    }

    public function indexAction() {
        $this->_initAction()
                ->renderLayout();
    }

    protected function _isAllowed() {
        return true;
    }
    
    public function updateTablesAction() {

        try {
            ini_set('max_execution_time', 0);
            $records = $this->_importGeoipAdmin(); //echo '<pre>';print_r($data);echo '</pre>';exit;
            if ($records) {
                Mage::getSingleton('adminhtml/session')->addSuccess('Table imported successfully! ' . $records . ' records imported!');
            }
        } catch (Mage_Core_Exception $ex) {
            Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
        } catch (Exception $exx) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('geoipdefaultlanguage')->__('Invalid File type!' . ' (' . $exx->getMessage() . ')'));
        }

        $this->_redirect('*/*/');
    }

    protected function _importGeoipAdmin() {

        $_lineLength = 0;
        $_delimiter = ',';
        $_enclosure = '"';


        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $csvdbpath = Mage::getBaseDir('media') . DS . "geoipdefaultlanguage" . DS . "GeoIPCountryWhois.csv";
        $fh = fopen($csvdbpath, 'r');

        if ($fh) {

            $fileno = 0;
            $lineno = 0;
            $startofnewfile = true;
            $lastlineno = 0;
            while ($rowData = fgets($fh, 300)) {

                //Create new file
                if ($startofnewfile) {
                    $startofnewfile = false;
                    $lastlineno = 0;
                    //Create a file with unique name
                    $file = Mage::getBaseDir('media') . DS . "geoipdefaultlanguage" . DS . "GeoIPCountry_" . $fileno . ".csv";

                    $fw = fopen($file, 'w');
                }
                //write csv Line to the taret file in append mode.
                $fwrite = fwrite($fw, $rowData);

                //Count line numbers
                $lineno++;
                //Reached the limit of file now prepare to start new file
                if ($lineno == 20000) {
                    $lastlineno = $lineno;
                    fclose($fw);
                    $lineno = 0;
                    $startofnewfile = true;
                    $fileno++;
                }
            }
            if ($lastlineno == 0) {
                fclose($fw);
            }
        } else {

            Mage::throwException(Mage::helper('adminhtml')->__('File GeoIPCountryWhois.csv do not exists'));
        }

        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $number = 0;

        $found = true;
        $partno = 0;
        while ($found) {
            $csvpath = Mage::getBaseDir('media') . DS . "geoipdefaultlanguage" . DS . "GeoIPCountry_" . $partno . ".csv";
            if (file_exists($csvpath)) {
                $found = true;

                $fh = fopen($csvpath, "r");

                if ($fh == false) {
                    Mage::throwException(Mage::helper('adminhtml')->__('File GeoIPCountryWhois.csv do not exists'));
                } else {
                    $csvObject = new Varien_File_Csv();
                    $csvData = $csvObject->getData($csvpath);

                    fclose($fh);

                    if (count($csvData[0]) == 6) {
                        if ($partno == 0) {
                            $resource = Mage::getSingleton('core/resource');
                            $writeConnection = $resource->getConnection('core_write');
                            $readConnection = $resource->getConnection('core_read');
                        }

                        foreach ($csvData as $k => $v) {
                            if ($k == 0 && $partno == 0) {
                                $installer = new Mage_Core_Model_Resource_Setup('core_setup');
                                $installer->startSetup();

                                $installer->run("
                                    DROP TABLE IF EXISTS {$installer->getTable('geoip_cl')};
                                    CREATE TABLE {$installer->getTable('geoip_cl')} (
                                        ci tinyint(3) unsigned NOT NULL auto_increment,
                                        cc char(2) NOT NULL,
                                        cn varchar(50) NOT NULL,
                                        PRIMARY KEY (ci)
                                    ) AUTO_INCREMENT=1 ;
                                    DROP TABLE IF EXISTS {$installer->getTable('geoip_csv')};
                                    CREATE TABLE {$installer->getTable('geoip_csv')} (
                                        start_ip char(15)NOT NULL,
                                        end_ip char(15)NOT NULL,
                                        start int(10) unsigned NOT NULL,
                                        end int(10) unsigned NOT NULL,
                                        cc char(2) NOT NULL,
                                        cn varchar(50) NOT NULL
                                    );
                                    DROP TABLE IF EXISTS {$installer->getTable('geoip_ip')};
                                    CREATE TABLE {$installer->getTable('geoip_ip')} (
                                        start int(10) unsigned NOT NULL,
                                        end int(10) unsigned NOT NULL,
                                        ci tinyint(3) unsigned NOT NULL
                                    );
                                ");

                                $installer->endSetup();
                            }

                            //end of file has more then one empty lines
                            if (count($v) <= 1 && !strlen($v[0])) {
                                continue;
                            }

                            if (count($v) != 6) {

                                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Invalid file upload attempt'));
                            }



                            if (!empty($v[0])) {

                                try {

                                    $countryname = Mage::getSingleton('core/resource')->getConnection('default_write')->quote($v[5]);

                                    $query = "INSERT INTO " . $resource->getTableName('geoip_csv') . " (start_ip, end_ip, start, end, cc, cn) VALUES ('{$v[0]}', '{$v[1]}', '{$v[2]}', '{$v[3]}', '{$v[4]}', {$countryname})";

                                    $writeConnection->query($query);
                                } catch (Exception $e) {
                                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                                    Mage::getSingleton('adminhtml/session')->setFormData($data);
                                    $this->_redirect('*/*/importExport');
                                    return;
                                }
                                $number++;
                            }
                        }//foreach

                        unset($csvData);
                    } else {

                        Mage::throwException(Mage::helper('adminhtml')->__('Invalid file format upload attempt'));
                    }
                }//file do not exists

                $partno++;
            } else
                $found = false;
        }// while found

        if ($partno != 0) {

            $installer->startSetup();

            $installer->run("
                INSERT INTO " . $resource->getTableName('geoip_cl') . " SELECT DISTINCT NULL, cc, cn FROM " . $resource->getTableName('geoip_csv') . ";

                INSERT INTO " . $resource->getTableName('geoip_ip') . " SELECT start, end, ci FROM " . $resource->getTableName('geoip_csv') . " NATURAL JOIN " . $resource->getTableName('geoip_cl') . ";
            ");

            $installer->endSetup();
            //Delete all the temporary files craeted for import.
            $delfound = true;
            $delpartno = 0;
            while ($delfound) {
                $csvdelpath = Mage::getBaseDir('media') . DS . "geoipdefaultlanguage" . DS . "GeoIPCountry_" . $delpartno . ".csv";
                if (file_exists($csvdelpath)) {
                    unlink($csvdelpath);
                } else {
                    $delfound = false;
                }
                $delpartno++;
            }
        } else {
            Mage::throwException(Mage::helper('adminhtml')->__('GeoIP databse files not found.'));
        }

        return $number;
    }

    protected function _beginImport() {

        $file = Mage::getBaseDir('media') . DS . 'geoipdefaultlanguage' . DS . 'GeoIPCountryWhois.csv';
        $csvObj = new Varien_File_Csv();
        $data = $csvObj->getData($file); //echo '<pre>';print_r($data);exit;
        /* all csv data */
        if (!empty($data)) {

            $installer = new Mage_Core_Model_Resource_Setup('core_setup');
            $installer->startSetup();

            $installer->run("
                DROP TABLE IF EXISTS {$installer->getTable('geoip_cl')};
                    CREATE TABLE {$installer->getTable('geoip_cl')} (
                        ci tinyint(3) unsigned NOT NULL auto_increment,
                        cc char(2) NOT NULL,
                        cn varchar(50) NOT NULL,
                        PRIMARY KEY (ci)
                    ) AUTO_INCREMENT=1 ;
                    

                    DROP TABLE IF EXISTS {$installer->getTable('geoip_csv')};
                    CREATE TABLE {$installer->getTable('geoip_csv')} (
                        start_ip char(15)NOT NULL,
                        end_ip char(15)NOT NULL,
                        start int(10) unsigned NOT NULL,
                        end int(10) unsigned NOT NULL,
                        cc char(2) NOT NULL,
                        cn varchar(50) NOT NULL
                    );
                    
                    DROP TABLE IF EXISTS {$installer->getTable('geoip_ip')};
                    CREATE TABLE {$installer->getTable('geoip_ip')} (
                        start int(10) unsigned NOT NULL,
                        end int(10) unsigned NOT NULL,
                        ci tinyint(3) unsigned NOT NULL
                    );
            ");

            $installer->endSetup();
            //set_time_limit(72000);
            $i = 0;
            $resource = Mage::getSingleton('core/resource');
            $write = $resource->getConnection('core_write');
            $query = '';
            foreach ($data as $_ix) {

                try {

                    $countryname = Mage::getSingleton('core/resource')->getConnection('default_write')->quote($_ix[5]);
                    $query = "INSERT INTO " . $resource->getTableName('geoip_csv') . " 
                         (start_ip, end_ip, start, end, cc, cn) 
                         VALUES ('{$_ix[0]}', '{$_ix[1]}', '{$_ix[2]}', '{$_ix[3]}', '{$_ix[4]}', $countryname);";
                    $write->query($query);

                    $i++;
                } catch (Exception $ex) {

                    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('geoipdefaultlanguage')->__($ex->getMessage() . ' Query: ' . $query));
                    $this->_redirect('*/*/');
                    return;
                }
            }

            if ($i > 0) {

                try {

                    $installer->startSetup();

                    $installer->run("
                        INSERT INTO " . $resource->getTableName('geoip_cl') . " 
                            SELECT DISTINCT NULL, cc, cn FROM " . $resource->getTableName('geoip_csv') . ";
                        INSERT INTO " . $resource->getTableName('geoip_ip') . " 
                            SELECT start, end, ci FROM " . $resource->getTableName('geoip_csv') . " NATURAL JOIN " . $resource->getTableName('geoip_cl') . ";
                    ");
                    $installer->endSetup();
                } catch (Exception $e) {

                    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('geoipdefaultlanguage')->__($e->getMessage()));
                }
            }
        }

        return $i;
    }

}
