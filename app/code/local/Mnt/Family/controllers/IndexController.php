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
 
class Mnt_Family_IndexController extends Mage_Core_Controller_Front_Action {        
   
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
	
	public function prescriptionAction(){
		//echo "in form submit...prescriptionAction" . "</br>";
		
		if (Mage::getSingleton('customer/session')->isLoggedIn()) {
			//echo "logged  in .......";
		}else{
			$this->loadLayout();
			Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('customer/account/login/'));
			$this->renderLayout();
		}

	}
	
    public function indexAction()
    {
		$userId = Mage::helper('customer')->getCustomer()->getId();
		//echo Mage::helper('customer')->getCustomer()->getId();
		
		//if ($this->getRequest()->isPost()){
			$userName = $this->getRequest()->getPost('userName');
			$relation = $this->getRequest()->getPost('relation');
			$vision = $this->getRequest()->getPost('vision');
			$vision_type = $this->getRequest()->getPost('vision_type');
			$drs = $this->getRequest()->getPost('drs');
			$drc = $this->getRequest()->getPost('drc');
			$dra = $this->getRequest()->getPost('dra');
			$dls = $this->getRequest()->getPost('dls');
			$dlc = $this->getRequest()->getPost('dlc');
			$dla = $this->getRequest()->getPost('dla');
			
			$rrs = $this->getRequest()->getPost('rrs');
			$rrc = $this->getRequest()->getPost('rrc');
			$rra = $this->getRequest()->getPost('rra');
			$rls = $this->getRequest()->getPost('rls');
			$rlc = $this->getRequest()->getPost('rlc');
			$rla = $this->getRequest()->getPost('rla');
			
			$ars = $this->getRequest()->getPost('ars');
			$ala = $this->getRequest()->getPost('ala');
			$pd = $this->getRequest()->getPost('pd');
			
		//}
			
		$model = Mage::getModel('mymod/family')
			->setName($userName)
			->setRelation($relation)
			->setVision($vision)
			->setVision_type($vision_type)
			->setUser_id($userId)
			->setDrs($drs)
			->setDrc($drc)
			->setDra($dra)
			->setDls($dls)
			->setDlc($dlc)
			->setDla($dla)
			->setRrs($rrs)
			->setRrc($rrc)
			->setRra($rra)
			->setRls($rls)
			->setRlc($rlc)
			->setRla($rla)
			->setArs($ars)
			->setAla($ala)
			->setPd($pd)
			->save();
			
		$this->loadLayout();
		$this->_redirectReferer();
		$this->renderLayout();
    }
	
	public function updateAction()
    {
		$userId = Mage::helper('customer')->getCustomer()->getId();
	//	echo Mage::helper('customer')->getCustomer()->getId();
		
		//if ($this->getRequest()->isPost()){
			$family_id = $this->getRequest()->getPost('family_id');
			$name = $this->getRequest()->getPost('name');
			$sphere = $this->getRequest()->getPost('sphere');
			$cylinder = $this->getRequest()->getPost('cylinder');
			$axis = $this->getRequest()->getPost('axis');
			$addition = $this->getRequest()->getPost('addition');
			$pupillary = $this->getRequest()->getPost('pupillary');
		//}
		$id = $family_id;	
		$data = array('name'=>$name,'sphere'=>$sphere,'cylinder'=>$cylinder,'axis'=>$axis,'addition'=>$addition,'pupillary'=>$pupillary);
		$model = Mage::getModel('mymod/family')->load($id)->addData($data);
		$model->setId($id)->save();
			
		$this->loadLayout();
		//$this->_redirectReferer();
		$this->renderLayout();
		
	}
	
	public function updateSingleAction()
    {
		$userId = Mage::helper('customer')->getCustomer()->getId();
		echo Mage::helper('customer')->getCustomer()->getId();
		
		$family_id = $this->getRequest()->getPost('familySingleId');
		$userName= $this->getRequest()->getPost('userName');
			$relation = $this->getRequest()->getPost('relation');
			$vision = $this->getRequest()->getPost('vision');
			$vision_type = $this->getRequest()->getPost('vision_type');
			$drs = $this->getRequest()->getPost('drs');
			$drc = $this->getRequest()->getPost('drc');
			$dra = $this->getRequest()->getPost('dra');
			$dls = $this->getRequest()->getPost('dls');
			$dlc = $this->getRequest()->getPost('dlc');
			$dla = $this->getRequest()->getPost('dla');
			
			$ars = $this->getRequest()->getPost('ars');
			$ala = $this->getRequest()->getPost('ala');
			$pd = $this->getRequest()->getPost('pd');

		$id = $family_id;	
		$data = array('name'=>$userName,'relation'=>$relation,'drs'=>$drs,'drc'=>$drc,'dra'=>$dra,'dls'=>$dls,'dlc'=>$dlc
		,'dla'=>$dla,'ars'=>$ars,'ala'=>$ala,'pd'=>$pd);
		$model = Mage::getModel('mymod/family')->load($id)->addData($data);
		$model->setId($id)->save();
			
		$this->loadLayout();
		$this->_redirectReferer();
		$this->renderLayout();
		
	}
	
	public function updateProgressiveAction()
    {
		$userId = Mage::helper('customer')->getCustomer()->getId();
		echo Mage::helper('customer')->getCustomer()->getId();
		
		$family_id1 = $this->getRequest()->getPost('family_id1');
		$userName1= $this->getRequest()->getPost('userName1');
			$relation1 = $this->getRequest()->getPost('relation1');
			$vision1 = $this->getRequest()->getPost('vision1');
			$vision_type1 = $this->getRequest()->getPost('vision_type');
			$drs1 = $this->getRequest()->getPost('drs1');
			$drc1 = $this->getRequest()->getPost('drc1');
			$dra1 = $this->getRequest()->getPost('dra1');
			$dls1 = $this->getRequest()->getPost('dls1');
			$dlc1 = $this->getRequest()->getPost('dlc1');
			$dla1 = $this->getRequest()->getPost('dla1');
			
			$rrs1 = $this->getRequest()->getPost('rrs1');
			$rrc1 = $this->getRequest()->getPost('rrc1');
			$rra1 = $this->getRequest()->getPost('rra1');
			$rls1 = $this->getRequest()->getPost('rls1');
			$rlc1 = $this->getRequest()->getPost('rlc1');
			$rla1 = $this->getRequest()->getPost('rla1');
			
			$ars1 = $this->getRequest()->getPost('ars1');
			$ala1 = $this->getRequest()->getPost('ala1');
			$pd1 = $this->getRequest()->getPost('pd1');

		$id = $family_id1;	
		$data = array('name'=>$userName1,'relation'=>$relation1,'drs'=>$drs1,'drc'=>$drc1,'dra'=>$dra1,'dls'=>$dls1,'dlc'=>$dlc1
		,'dla'=>$dla1,'rrs'=>$rrs1,'rrc'=>$rrc1,'rra'=>$rra1,'rls'=>$rls1,'rlc'=>$rlc1,'rla'=>$rla1,'ars'=>$ars1,'ala'=>$ala1
		,'pd'=>$pd1);
		$model = Mage::getModel('mymod/family')->load($id)->addData($data);
		$model->setId($id)->save();
			
		$this->loadLayout();
		$this->_redirectReferer();
		$this->renderLayout();
		
	}
	
	public function deleteAction()
    {
		$userId = Mage::helper('customer')->getCustomer()->getId();
		echo Mage::helper('customer')->getCustomer()->getId();
		
		$delete_id = $this->getRequest()->getPost('delete_id');
		$id = $delete_id;	
		$deleteCCL = Mage::getModel('mymod/family');
		$deleteCCL->load($id);
		$deleteCCL->delete();		
			
		$this->loadLayout();
		$this->_redirectReferer();
		$this->renderLayout();
		
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
	//Mage::register('productInfo', $products);
	//$my_array = array("Dog","Cat","Horse");
	//Mage::register('optionTag', $my_array);
	
	
	$this->loadLayout();
	$block = $this->getLayout()->createBlock('Mage_Core_Block_Template','popup2_form2',array('template' => 'customer/account/edit/'));
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
