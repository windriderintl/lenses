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
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Product list
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Catalog_Block_Product_List extends Mage_Catalog_Block_Product_Abstract
{
    /**
     * Default toolbar block name
     *
     * @var string
     */
    protected $_defaultToolbarBlock = 'catalog/product_list_toolbar';

    /**
     * Product Collection
     *
     * @var Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected $_productCollection;

    /**
     * Retrieve loaded category collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
            $layer = $this->getLayer();
            /* @var $layer Mage_Catalog_Model_Layer */
            if ($this->getShowRootCategory()) {
                $this->setCategoryId(Mage::app()->getStore()->getRootCategoryId());
            }

            // if this is a product view page
            if (Mage::registry('product')) {
                // get collection of categories this product is associated with
                $categories = Mage::registry('product')->getCategoryCollection()
                    ->setPage(1, 1)
                    ->load();
					
                // if the product is associated with any category
                if ($categories->count()) {
                    // show products from this category
                    $this->setCategoryId(current($categories->getIterator()));
                }
            }

            $origCategory = null;
            if ($this->getCategoryId()) {
                $category = Mage::getModel('catalog/category')->load($this->getCategoryId());
                if ($category->getId()) {
                    $origCategory = $layer->getCurrentCategory();
                    $layer->setCurrentCategory($category);
                    $this->addModelTags($category);
                }
            }
            $this->_productCollection = $layer->getProductCollection();

            $this->prepareSortableFieldsByCategory($layer->getCurrentCategory());

            if ($origCategory) {
                $layer->setCurrentCategory($origCategory);
            }
        }

        return $this->_productCollection;
    }

    /**
     * Get catalog layer model
     *
     * @return Mage_Catalog_Model_Layer
     */
    public function getLayer()
    {
        $layer = Mage::registry('current_layer');
        if ($layer) {
            return $layer;
        }
        return Mage::getSingleton('catalog/layer');
    }

    /**
     * Retrieve loaded category collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getLoadedProductCollection()
    {
        return $this->_getProductCollection();
    }

    /**
     * Retrieve current view mode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->getChild('toolbar')->getCurrentMode();
    }

    /**
     * Need use as _prepareLayout - but problem in declaring collection from
     * another block (was problem with search result)
     */
   protected function _beforeToHtml()
    {
        $toolbar = $this->getToolbarBlock();

        // called prepare sortable parameters
        $collection = $this->_getProductCollection();
		
        // use sortable parameters
        if ($orders = $this->getAvailableOrders()) {
            $toolbar->setAvailableOrders($orders);
        }
        if ($sort = $this->getSortBy()) {
            $toolbar->setDefaultOrder($sort);
        }
        if ($dir = $this->getDefaultDirection()) {
            $toolbar->setDefaultDirection($dir);
        }
        if ($modes = $this->getModes()) {
            $toolbar->setModes($modes);
        }
		
		$layer = Mage::getSingleton('catalog/layer');
		$_category = $layer->getCurrentCategory();
		
		//if ($this->getRequest()->isPost()){
		if ($_category->getId() == 37){
			$gender = $this->getRequest()->getPost('gender');
			$clothStyle = $this->getRequest()->getPost('clothStyle');
			$face = $this->getRequest()->getPost('face');
			$holiday = $this->getRequest()->getPost('holiday');
			$eyesColor = $this->getRequest()->getPost('eyesColor');
			
			if($gender == null){
				$gender = Mage::getSingleton('core/session')->getGenderMessage();
				$clothStyle = Mage::getSingleton('core/session')->getClothStyleMessage();
				$face = Mage::getSingleton('core/session')->getFaceMessage();
				$holiday = Mage::getSingleton('core/session')->getHolidayMessage();
				$eyesColor = Mage::getSingleton('core/session')->getEyesColorMessage();
			}else{
				Mage::getSingleton('core/session')->setGenderMessage($gender);
				Mage::getSingleton('core/session')->setClothStyleMessage($clothStyle);
				Mage::getSingleton('core/session')->setFaceMessage($face);
				Mage::getSingleton('core/session')->setHolidayMessage($holiday);
				Mage::getSingleton('core/session')->setEyesColorMessage($eyesColor);
			}
			// echo $gender . "<br />";
			// echo $clothStyle . "<br />";
			// echo $face . "<br />";
			// echo $holiday . "<br />";
			// echo $eyesColor . "<br />";
			
			//for Gender .....
			if($gender == "men"){
				$gen = '65';
			}else if($gender == "women"){
				$gen = '66';
			}else{
				$gen = ' ';
			}
			
			//for Style .....
			if($clothStyle == 'business'){
				$clothStyleValue1 = '148'; //Classic = 148
				$clothStyleValue2 = ' '; 
			}else if($clothStyle == 'trend'){
				$clothStyleValue1 = '149';  //Mode = 149
				$clothStyleValue2 = ' '; 
			}else if($clothStyle == 'sports'){
				$clothStyleValue1 = '150';  // Fun = 150
				$clothStyleValue2 = '148';  
			}else if($clothStyle == 'retro'){
				$clothStyleValue1 = '149';  
				$clothStyleValue2 = ' '; 
			}else if($clothStyle == 'casual'){
				$clothStyleValue1 = '148';
				$clothStyleValue2 = '149';
			}else if($clothStyle == 'eccentric'){
				$clothStyleValue1 = '150';
				$clothStyleValue2 = ' '; 				
			}else{
				$clothStyleValue1 = ' ';
				$clothStyleValue2 = ' '; 
			}
			
			//for Shape .....
			if($face == 'oval'){
				$faceValue1 = '136'; //Aviator = 136
				$faceValue2 = '133'; //Butterfly = 133
				$faceValue3 = '134'; //Half-moon = 134
				$faceValue4 = '130'; //Oval = 130
				$faceValue5 = '131'; //Round = 131
				$faceValue6 = '132'; //Square = 132
				$faceValue7 = '135'; //Wayfarer = 135
			}else if($face == 'triangular'){
				$faceValue1 = '136'; //Aviator = 136
				$faceValue2 = '134';  //Half-moon = 134
				$faceValue3 = '130'; //Oval = 130
				$faceValue4 = '131'; //Round = 131
				$faceValue5 = '135';  //Wayfarer = 135
				$faceValue6 = ' ';
				$faceValue7 = ' ';
			}else if($face == 'round'){
				$faceValue1 = '131'; //Round = 131
				$faceValue2 = '132'; //Square = 132
				$faceValue3 = '133'; //Butterfly = 133
				$faceValue4 = '135'; //Wayfarer = 135
				$faceValue5 = ' ';
				$faceValue6 = ' ';
				$faceValue7 = ' ';
			}else if($face == 'square'){
				$faceValue1 = '130'; //Oval = 130
				$faceValue2 = '131'; //Round = 131
				$faceValue3 = '133'; //Butterfly = 133
				$faceValue4 = '134'; //Half-moon = 134
				$faceValue5 = ' ';
				$faceValue6 = ' ';
				$faceValue7 = ' ';
			}
		
			//for Holiday .....
			if($holiday == 'campaign'){
				$holidayValue1 = '146'; //Wood = 146
				$holidayValue2 = '144'; //Titanium = 144
				$holidayValue3 = '143'; //Carbone = 143
			}else if($holiday == 'sea'){
				$holidayValue1 = '145';  //Acetate = 145
				$holidayValue2 = '146';  //Wood = 146
				$holidayValue3 = '144'; //Titanium = 144
				$holidayValue4 = '143'; //Carbone = 143
			}else if($holiday == 'ville'){
				$holidayValue1 = '147';  // Metal = 147
				$holidayValue2 = '144'; //Titanium = 144
				$holidayValue3 = '143'; //Carbone = 143
			}
			
			//for Color .....
			if($eyesColor == 'brown'){
				$colorValue1 = '155'; //Wood = 155
				$colorValue2 = '154'; //Green = 154
				$colorValue3 = '24'; //Marron = 24
				$colorValue4 = '25'; //Red = 25
				$colorValue5 = '59'; //Grey = 59
				$colorValue6 = '61'; //Black = 61
				$colorValue7 = '22'; //Blue = 22
				$colorValue8 = '58'; //Purple = 58
				$colorValue9 = '57'; //Pink = 57
				$colorValue10 = '26'; //Multi-colors = 26
				$colorValue11 = '23'; //Beige = 23
				$colorValue12= '60'; //Orange = 60
				$colorValue13 = ' '; 
				$colorValue14 = ' '; 
			}else if($eyesColor == 'black'){
				$colorValue1 = '155'; //Wood = 155
				$colorValue2 = '154'; //Green = 154
				$colorValue3 = '24'; //Marron = 24
				$colorValue4 = '25'; //Red = 25
				$colorValue5 = '59'; //Grey = 59
				$colorValue6 = '61'; //Black = 61
				$colorValue7 = '22'; //Blue = 22
				$colorValue8 = '58'; //Purple = 58
				$colorValue9 = '57'; //Pink = 57
				$colorValue10 = '26'; //Multi-colors = 26
				$colorValue11 = '60'; //Orange = 60 
				$colorValue12 = ' ';  //White = 152
				$colorValue13 = ' '; 
				$colorValue14 = ' '; 
			}else if($eyesColor == 'blue'){
				$colorValue1 = '155'; //Wood = 155
				$colorValue2 = '152';  //White = 152
				$colorValue3 = '153';  //Yellow = 153
				$colorValue4 = '154'; //Green = 154
				$colorValue5 = '24'; //Marron = 24
				$colorValue6 = '25'; //Red = 25
				$colorValue7 = '59'; //Grey = 59
				$colorValue8 = '61'; //Black = 61
				$colorValue9 = '58'; //Purple = 58
				$colorValue10 = '57'; //Pink = 57
				$colorValue11 = '26'; //Multi-colors = 26
				$colorValue12 = '23'; //Beige = 23
				$colorValue13= '60'; //Orange = 60
				$colorValue14 = ' ';
			}else if($eyesColor == 'green'){
				$colorValue1 = '155'; //Wood = 155
				$colorValue2 = '152';  //White = 152
				$colorValue3 = '24'; //Marron = 24
				$colorValue4 = '25'; //Red = 25
				$colorValue5 = '59'; //Grey = 59
				$colorValue6 = '61'; //Black = 61
				$colorValue7 = '22'; //Blue = 22
				$colorValue8 = '58'; //Purple = 58
				$colorValue9 = '26'; //Multi-colors = 26
				$colorValue10 = '23'; //Beige = 23
				$colorValue11= '60'; //Orange = 60
				$colorValue12 = ' ';
				$colorValue13 = ' ';
				$colorValue14 = ' ';
				
			}
			
			$collection->addAttributeToFilter('gender',array(array("finset" => array('36')),array("finset" => array($gen)),))
				       ->addAttributeToFilter('style', array(array("finset" => array($clothStyleValue1)),
													   array("finset" => array($clothStyleValue2)),))
					   ->addAttributeToFilter('shape', array(array("finset" => array($faceValue1)),
													   array("finset" => array($faceValue2)),
													   array("finset" => array($faceValue3)),
													   array("finset" => array($faceValue4)),
													   array("finset" => array($faceValue5)),
													   array("finset" => array($faceValue6)),
													   array("finset" => array($faceValue7)),))
					   ->addAttributeToFilter('row_material', array(array("finset" => array($holidayValue1)),
													   array("finset" => array($holidayValue2)),
													   array("finset" => array($holidayValue3)),
													   array("finset" => array($holidayValue4)),))
					   ->addAttributeToFilter('color', array(array("finset" => array($colorValue1)),
													   array("finset" => array($colorValue2)),
													   array("finset" => array($colorValue3)),
													   array("finset" => array($colorValue4)),
													   array("finset" => array($colorValue5)),
													   array("finset" => array($colorValue6)),
													   array("finset" => array($colorValue7)),
													   array("finset" => array($colorValue8)),
													   array("finset" => array($colorValue9)),
													   array("finset" => array($colorValue10)),
													   array("finset" => array($colorValue11)),
													   array("finset" => array($colorValue12)),
													   array("finset" => array($colorValue13)),
													   array("finset" => array($colorValue14)),));
			
		}
	
        // set collection to toolbar and apply sort
        $toolbar->setCollection($collection);

        $this->setChild('toolbar', $toolbar);
        Mage::dispatchEvent('catalog_block_product_list_collection', array(
            'collection' => $this->_getProductCollection()
        ));

        $this->_getProductCollection()->load();
		//echo $this->_getProductCollection()->load();
        return parent::_beforeToHtml();
    }
	

    /**
     * Retrieve Toolbar block
     *
     * @return Mage_Catalog_Block_Product_List_Toolbar
     */
    public function getToolbarBlock()
    {
        if ($blockName = $this->getToolbarBlockName()) {
            if ($block = $this->getLayout()->getBlock($blockName)) {
                return $block;
            }
        }
        $block = $this->getLayout()->createBlock($this->_defaultToolbarBlock, microtime());
        return $block;
    }

    /**
     * Retrieve additional blocks html
     *
     * @return string
     */
    public function getAdditionalHtml()
    {
        return $this->getChildHtml('additional');
    }

    /**
     * Retrieve list toolbar HTML
     *
     * @return string
     */
    public function getToolbarHtml()
    {
        return $this->getChildHtml('toolbar');
    }

    public function setCollection($collection)
    {
        $this->_productCollection = $collection;
        return $this;
    }

    public function addAttribute($code)
    {
        $this->_getProductCollection()->addAttributeToSelect($code);
        return $this;
    }

    public function getPriceBlockTemplate()
    {
        return $this->_getData('price_block_template');
    }

    /**
     * Retrieve Catalog Config object
     *
     * @return Mage_Catalog_Model_Config
     */
    protected function _getConfig()
    {
        return Mage::getSingleton('catalog/config');
    }

    /**
     * Prepare Sort By fields from Category Data
     *
     * @param Mage_Catalog_Model_Category $category
     * @return Mage_Catalog_Block_Product_List
     */
    public function prepareSortableFieldsByCategory($category) {
        if (!$this->getAvailableOrders()) {
            $this->setAvailableOrders($category->getAvailableSortByOptions());
        }
        $availableOrders = $this->getAvailableOrders();
        if (!$this->getSortBy()) {
            if ($categorySortBy = $category->getDefaultSortBy()) {
                if (!$availableOrders) {
                    $availableOrders = $this->_getConfig()->getAttributeUsedForSortByArray();
                }
                if (isset($availableOrders[$categorySortBy])) {
                    $this->setSortBy($categorySortBy);
                }
            }
        }

        return $this;
    }

    /**
     * Retrieve block cache tags based on product collection
     *
     * @return array
     */
    public function getCacheTags()
    {
        return array_merge(
            parent::getCacheTags(),
            $this->getItemsTags($this->_getProductCollection())
        );
    }
}
