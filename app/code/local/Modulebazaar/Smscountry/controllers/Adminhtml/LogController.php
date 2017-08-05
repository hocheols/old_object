<?php
 
class Modulebazaar_Smscountry_Adminhtml_LogController extends Mage_Adminhtml_Controller_Action
{
 
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('smscountry/items');
        $this->renderLayout();
    }
 
    public function newAction()
    {
        $this->_forward('edit');
    }
 
    public function editAction()
    {
	$id     = $this->getRequest()->getParam('id');
	$model  = Mage::getModel('smscountry/log')->load($id);

	if ($model->getId() || $id == 0)
	{
	    $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
	    if (!empty($data)) {
		    $model->setData($data);
	    }

	    Mage::register('log_data', $model);

	    $this->loadLayout();
	    $this->_setActiveMenu('smscountry/items');

	    $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
	    $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

	    $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
	    
	    $this->_addContent($this->getLayout()->createBlock('smscountry/adminhtml_log_edit'))
		    ->_addLeft($this->getLayout()->createBlock('smscountry/adminhtml_log_edit_tabs'));

		$this->renderLayout();
	} else {
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('smscountry')->__('Item does not exist'));
		$this->_redirect('*/*/');
	}
    }
 
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost())
        {
            $model = Mage::getModel('smscountry/log');
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }
            $model->setData($data);
 
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            try {
                if ($id) {
                    $model->setId($id);
                }
                $model->save();
 
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('smscountry')->__('Error saving log'));
                }
 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('smscountry')->__('Log was successfully saved.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
 
                // The following line decides if it is a "save" or "save and continue"
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/');
                }
 
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                if ($model && $model->getId()) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/');
                }
            }
 
            return;
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('smscountry')->__('No data found to save'));
        $this->_redirect('*/*/');
    }
 
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('smscountry/log');
                $model->setId($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('smscountry')->__('The log has been deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to find the log to delete.'));
        $this->_redirect('*/*/');
    }
    
    public function massDeleteAction() {
        $logIds = $this->getRequest()->getParam('smscountry');
        if(!is_array($logIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($logIds as $logId) {
                    $log = Mage::getModel('smscountry/log')->load($logId);
                    $log->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($logIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $logIds = $this->getRequest()->getParam('smscountry');
        if(!is_array($logIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($logIds as $logId) {
                    $log = Mage::getSingleton('smscountry/log')
                        ->load($logId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($logIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
 
}