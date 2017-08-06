<?php

class FME_Geoipdefaultlanguage_Adminhtml_GeoipdefaultlanguageController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('geoipdefaultlanguage/items')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

        return $this;
    }

    public function indexAction() {
        $this->_initAction()
                ->renderLayout();
    }

    protected function _isAllowed() {
        return true;
    }
    
    public function editAction() {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('geoipdefaultlanguage/geoipdefaultlanguage')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('geoipdefaultlanguage_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('geoipdefaultlanguage/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('geoipdefaultlanguage/adminhtml_geoipdefaultlanguage_edit'))
                    ->_addLeft($this->getLayout()->createBlock('geoipdefaultlanguage/adminhtml_geoipdefaultlanguage_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('geoipdefaultlanguage')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function saveAction() {

        if ($data = $this->getRequest()->getPost()) {
            
            $_helper = Mage::helper('geoipdefaultlanguage');
            // allow only valid ip
            if ($data['ip_to_exception'] != '') {

                $_arr = preg_split('@,@', $data['ip_to_exception'], NULL, PREG_SPLIT_NO_EMPTY);
                $data['ip_to_exception'] = (!empty($_arr)) ? implode(",", $_arr) : '';
            }
            
            if (count($data['store']) > 1) {
                Mage::getSingleton('adminhtml/session')->addError($_helper->__('Please select only one store!'));
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            
            if (count($data['store']) > 1) {
                Mage::getSingleton('adminhtml/session')->addError($_helper->__('Please select only one store!'));
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            
            if (count($data['currency']) > 1) {
                
                Mage::getSingleton('adminhtml/session')->addError($_helper->__('Please select only one currency!'));
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
                
            }
            
            $data['store'] = $data['store'][0];
            $data['currency'] = $data['currency'][0];
            
            $model = Mage::getModel('geoipdefaultlanguage/geoipdefaultlanguage');
            $model->setData($data)
                    ->setId($this->getRequest()->getParam('id'));

            if (isset($data['countries_list']) && count($data['countries_list']) > 0) {
                $model->setCountriesList(serialize($data['countries_list']));
            }

            try {
                if ($model->getCreatedTime() == NULL || $model->getUpdateTime() == NULL) {
                    $model->setCreatedTime(now())
                            ->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                }

                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('geoipdefaultlanguage')->__('Group was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('geoipdefaultlanguage')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('geoipdefaultlanguage/geoipdefaultlanguage');

                $model->setId($this->getRequest()->getParam('id'))
                        ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction() {
        $geoipdefaultlanguageIds = $this->getRequest()->getParam('geoipdefaultlanguage');
        if (!is_array($geoipdefaultlanguageIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($geoipdefaultlanguageIds as $geoipdefaultlanguageId) {
                    $geoipdefaultlanguage = Mage::getModel('geoipdefaultlanguage/geoipdefaultlanguage')->load($geoipdefaultlanguageId);
                    $geoipdefaultlanguage->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__(
                                'Total of %d record(s) were successfully deleted', count($geoipdefaultlanguageIds)
                        )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction() {
        $geoipdefaultlanguageIds = $this->getRequest()->getParam('geoipdefaultlanguage');
        if (!is_array($geoipdefaultlanguageIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($geoipdefaultlanguageIds as $geoipdefaultlanguageId) {
                    $geoipdefaultlanguage = Mage::getSingleton('geoipdefaultlanguage/geoipdefaultlanguage')
                            ->load($geoipdefaultlanguageId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) were successfully updated', count($geoipdefaultlanguageIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction() {
        $fileName = 'geoipdefaultlanguage.csv';
        $content = $this->getLayout()->createBlock('geoipdefaultlanguage/adminhtml_geoipdefaultlanguage_grid')
                ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction() {
        $fileName = 'geoipdefaultlanguage.xml';
        $content = $this->getLayout()->createBlock('geoipdefaultlanguage/adminhtml_geoipdefaultlanguage_grid')
                ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType = 'application/octet-stream') {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK', '');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename=' . $fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        
    }

    public function getCountryListFormAction() {
        $this->getResponse()->setBody($this->getLayout()->createBlock('adminhtml/template', 'countrytabs', array('template' => 'geoipdefaultlanguage/blockcountryform.phtml'))->toHtml());
        
    }

}
