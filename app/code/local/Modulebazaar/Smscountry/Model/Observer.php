<?php

class Modulebazaar_Smscountry_Model_Observer {

    public function smscountryWhenOrderPlaced(Varien_Event_Observer $observer) {
        if (!$this->getHelper()->isEnabled()) {
            return;
        }

        if ($this->getHelper()->isOrderEnabled()) {
            $orders = $observer->getEvent()->getOrderIds();
            $order = Mage::getModel('sales/order')->load($orders['0']);
            if ($order instanceof Mage_Sales_Model_Order) {
                $title = 'Order SMS';
                $senderId = $this->getHelper()->getSenderId();
                $to = $this->getHelper()->getTelephoneFromOrder($order);
                $firstname = $order->getCustomerFirstname();
                $country = $this->getHelper()->getCountry($order);
                
                if($country == "IN")
                {
                    $messageType = 'order';
                    $this->getHelper()->sendSms($messageType);
                    $chars = $this->getHelper()->getChars();
                    $length = $this->getHelper()->getLength();
                    $smsStatus = $this->getHelper()->getSmsStatus();
                    try {
                        Mage::getModel('smscountry/log')
                                ->setSentDate(Mage::getModel('core/date')->timestamp(time()))
                                ->setOrderId($order->getIncrementId())
                                ->setTitle($title)
                                ->setSenderId($senderId)
                                ->setTo($to)
                                ->setRecipient($firstname)
                                ->setCountry($country)
                                ->setChars($chars)
                                ->setLength($length)
                                ->setStatus($smsStatus)
                                ->save();
                    }
                    catch (Exception $e)
                    {
                        echo $e;
                    }
                }
            }
        }
    }

    public function smscountryWhenInvoicePlaced(Varien_Event_Observer $observer) {
        if (!$this->getHelper()->isEnabled()) {
            return;
        }
        
        if ($this->getHelper()->isInvoiceEnabled()) {
            $invoice = $observer->getEvent()->getInvoice();
            $order = $invoice->getOrder();
            if ($order instanceof Mage_Sales_Model_Order) {
                $title = 'Invoice SMS';
                $senderId = $this->getHelper()->getSenderId();
                $to = $this->getHelper()->getTelephoneFromOrder($order);
                $firstname = $order->getCustomerFirstname();
                $country = $this->getHelper()->getCountry($order);
                if($country == "IN")
                {
                    $messageType = 'invoice';
                    $this->getHelper()->sendSms($messageType);
                    $chars = $this->getHelper()->getChars();
                    $length = $this->getHelper()->getLength();
                    $smsStatus = $this->getHelper()->getSmsStatus();
                    try {
                        Mage::getModel('smscountry/log')
                                ->setSentDate(Mage::getModel('core/date')->timestamp(time()))
                                ->setOrderId($order->getIncrementId())
                                ->setTitle($title)
                                ->setSenderId($senderId)
                                ->setTo($to)
                                ->setRecipient($firstname)
                                ->setCountry($country)
                                ->setChars($chars)
                                ->setLength($length)
                                ->setStatus($smsStatus)
                                ->save();
                    }
                    catch (Exception $e) {
                        echo $e;
                    }
                }
            }
        }
    }

    public function smscountryWhenShipmentCreated(Varien_Event_Observer $observer) {
        if (!$this->getHelper()->isEnabled()) {
            return;
        }

        if ($this->getHelper()->isShipmentEnabled()) {
            $shipment = $observer->getEvent()->getShipment();
            $order = $shipment->getOrder();
            if ($order instanceof Mage_Sales_Model_Order) {
                $title = 'Shipment SMS';
                $senderId = $this->getHelper()->getSenderId();
                $to = $this->getHelper()->getTelephoneFromOrder($order);
                $firstname = $order->getCustomerFirstname();
                $country = $this->getHelper()->getCountry($order);
                if($country == "IN")
                {
                    $messageType = 'shipment';
                    $this->getHelper()->sendSms($messageType);
                    $chars = $this->getHelper()->getChars();
                    $length = $this->getHelper()->getLength();
                    $smsStatus = $this->getHelper()->getSmsStatus();
                    try {
                        Mage::getModel('smscountry/log')
                                ->setSentDate(Mage::getModel('core/date')->timestamp(time()))
                                ->setOrderId($order->getIncrementId())
                                ->setTitle($title)
                                ->setSenderId($senderId)
                                ->setTo($to)
                                ->setRecipient($firstname)
                                ->setCountry($country)
                                ->setChars($chars)
                                ->setLength($length)
                                ->setStatus($smsStatus)
                                ->save();
                    }
                    catch (Exception $e) {
                        echo $e;
                    }
                }
            }
        }
    }

    public function smscountryWhenOrderCanceled(Varien_Event_Observer $observer)
    {
        if (!$this->getHelper()->isEnabled()) {
            return;
        }

        if ($this->getHelper()->isCanceledEnabled()) {
            $order = $observer->getOrder();
            if ($order instanceof Mage_Sales_Model_Order) {
                if ($order->getState() !== $order->getOrigData('state') && $order->getState() === Mage_Sales_Model_Order::STATE_CANCELED) {
                    $title = 'Canceled SMS';
                    $senderId = $this->getHelper()->getSenderId();
                    $to = $this->getHelper()->getTelephoneFromOrder($order);
                    $firstname = $order->getCustomerFirstname();
                    $country = $this->getHelper()->getCountry($order);
                    if($country == "IN")
                    {
                        $messageType = 'cancel';
                        $this->getHelper()->sendSms($messageType);
                        $chars = $this->getHelper()->getChars();
                        $length = $this->getHelper()->getLength();
                        $smsStatus = $this->getHelper()->getSmsStatus();
                        try {
                            Mage::getModel('smscountry/log')
                                    ->setSentDate(Mage::getModel('core/date')->timestamp(time()))
                                    ->setOrderId($order->getIncrementId())
                                    ->setTitle($title)
                                    ->setSenderId($senderId)
                                    ->setTo($to)
                                    ->setRecipient($firstname)
                                    ->setCountry($country)
                                    ->setChars($chars)
                                    ->setLength($length)
                                    ->setStatus($smsStatus)
                                    ->save();
                        }
                        catch (Exception $e) {
                            echo $e;
                        }
                    }
                }
            }
        }
    }

    public function getHelper()
    {
        return Mage::helper('smscountry');
    }
}
