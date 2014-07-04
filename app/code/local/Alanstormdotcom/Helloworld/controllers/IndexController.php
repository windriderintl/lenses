<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Customer
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Customer account controller
 *
 * @category   Mage
 * @package    Mage_Customer
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Alanstormdotcom_Helloworld_IndexController extends Mage_Core_Controller_Front_Action {        
   
    const XML_PATH_EMAIL_RECIPIENT  = 'contacts/email/recipient_email';
    const XML_PATH_EMAIL_SENDER     = 'contacts/email/sender_email_identity';
    const XML_PATH_EMAIL_TEMPLATE   = 'contacts/email/email_template';
    const XML_PATH_ENABLED          = 'contacts/contacts/enabled';

    public function preDispatch()
    {
        parent::preDispatch();

        if( !Mage::getStoreConfigFlag(self::XML_PATH_ENABLED) ) {
            $this->norouteAction();
        }
    }

    public function indexAction()
    {
		// $model = Mage::getModel('mymod/family')
			// ->setName('pankaj')
			// ->setUser_id(3)
			// ->setRelation('pankaj')
			// ->setAge(25)
			// ->setGender('Male')
			// ->save();
        $this->loadLayout();
        $this->renderLayout();
		//echo 'Hello Index!';
    }
	
	public function multiply1Action(){
		/** @var Mage_Sales_Model_Resource_Quote_Item_Option_Collection $options */
		$userId = Mage::helper('customer')->getCustomer()->getId();		
		//echo "string.........."+$userId;
	
		$collection = Mage::getModel('sales/quote_item_option')->getCollection();
		$collection->getColumnValues('item_id');
		//echo "size ".$collection->getSize();
		
		foreach ($collection as $option => $value) {
			//echo $value['value'];
			//$this = $value['value'];
		    $val =	unserialize($value['value']);
			//$val = $this->serialize($value['value']);
			//echo $val[0]['product'];
			foreach ($val as $key => $value) {
			    echo $key .'</br>';
				echo $value.'</br>';
			}
			// $item->addOption($option);
		}
	}
	
	public function multiplyAction(){
    if ($this->getRequest()->isPost()){
		$gender = $this->getRequest()->getPost('gender');
		$price = $this->getRequest()->getPost('price');
		//echo 'in if ...';
		//echo $gender;
		//echo $price . "<br />";
		// Mage::getSingleton('customer/session')->addSuccess("101");
		}
		$arr1 = explode( "-" , $price );
		$lowerLimit = $arr1[0];
		$upperLimit = $arr1[1];
		//echo $lowerLimit;
		//echo $upperLimit;
	
	//$genders = Mage::getModel('eav/entity_attribute_collection');
	//echo $genders;
	
	  $genders = array();
      $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'gender'); // "gender" is attribute_code
      $allOptions = $attribute->getSource()->getAllOptions(true, true);
	  $i = 0; 
      foreach ($allOptions as $instance) {
           $genders[$instance['value']] = $instance['label'];
		  // echo $genders[$instance['value']];
      }
	
	
	$products = Mage::getModel('catalog/product')
		->getCollection()
		->addAttributeToSelect("*")
		->setOrder('price', 'ASC')
		->addAttributeToFilter('price', array('gteq' => $lowerLimit))
		->addAttributeToFilter('price', array('lteq' => $upperLimit))
		->load();
	
	// foreach ($products as $product) {
		 // echo $i++;
		 // echo $product->getName() . "<br />";
		// echo $product->getDescription() . "<br />";
	// }
	
	//Mage::register('product', $_products);
	Mage::register('productInfo', $products);
	$my_array = array("Dog","Cat","Horse");
	Mage::register('optionTag', $my_array);
	
	
	$this->loadLayout();
	$block = $this->getLayout()->createBlock('Mage_Core_Block_Template','popup2_form2',array('template' => 'popup2/form.phtml'));
	$this->getLayout()->getBlock('content')->append($block);
    //$value = $this->_initLayoutMessages('customer/session');
	//echo $value;
		
    $this->renderLayout();
}
	
    public function postAction()
    {
        $post = $this->getRequest()->getPost();
        if ( $post ) {
            $translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
            try {
                $postObject = new Varien_Object();
                $postObject->setData($post);

                $error = false;

                if (!Zend_Validate::is(trim($post['Gender']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['comment']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                    $error = true;
                }

                if (Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
                    $error = true;
                }

                if ($error) {
                    throw new Exception();
                }
                $mailTemplate = Mage::getModel('core/email_template');
                /* @var $mailTemplate Mage_Core_Model_Email_Template */
                $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($post['email'])
                    ->sendTransactional(
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT),
                        null,
                        array('data' => $postObject)
                    );

                if (!$mailTemplate->getSentSuccess()) {
                    throw new Exception();
                }

                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addSuccess(Mage::helper('contacts')->__('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.'));
                $this->_redirect('*/*/');

                return;
            } catch (Exception $e) {
                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Unable to submit your request. Please, try again later'));
                $this->_redirect('*/*/');
                return;
            }

        } else {
            $this->_redirect('*/*/');
        }
    }
}
