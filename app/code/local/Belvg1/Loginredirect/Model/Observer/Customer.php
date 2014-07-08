
<?php
	public function customerLogin(Varien_Event_Observer $observer)
   {
       if (Mage::helper('loginredirect')->isEnabled()) {
           $_session = $this->_getSession();
           $_session->setBeforeAuthUrl(Mage::helper('loginredirect')->getRedirectUrl());
       }
   }

   /**
    * @return Mage_Core_Model_Abstract
    */
   protected function _getSession()
   {
       return Mage::getSingleton('customer/session');
   }