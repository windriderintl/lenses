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

		$clearData = false;
		if ($this->getRequest()->isPost()){
		
			$clearData = true;
			$gender = $this->getRequest()->getPost('gender');
			$clothStyle = $this->getRequest()->getPost('clothStyle');
			$face = $this->getRequest()->getPost('face');
			$holiday = $this->getRequest()->getPost('holiday');
			$eyesColor = $this->getRequest()->getPost('eyesColor');
			//echo $clearData;
			echo $gender . "<br />";
			echo $clothStyle . "<br />";
			echo $face . "<br />";
			echo $holiday . "<br />";
			echo $eyesColor . "<br />";
			$clothStyleValue1 = ' ';
			$clothStyleValue2 = ' ';	
			$faceValue1 = ' '; 
			$faceValue2 = ' '; 
			$faceValue3 = ' '; 
			$faceValue4 = ' ';
			$faceValue5 = ' '; 			
			$faceValue6 = ' '; 
			$faceValue7 = ' '; 
			//$arr1 = explode( "-" , $price );
			//$lowerLimit = $arr1[0];
			//$upperLimit = $arr1[1];
			//echo $lowerLimit;
			//echo $upperLimit;
			
			//Mage::getSingleton('core/session')->setPriceLowerLimit($lowerLimit);
			//Mage::getSingleton('core/session')->setPriceUpperLimit($upperLimit);
			//Mage::getSingleton('core/session')->setshape($shape);
			//Mage::getSingleton('core/session')->setGender($gender);

			if($gender == "men"){
				$gen = '65';
			}else{
				$gen = '66';
			}
			if($clothStyle == 'business'){
				$clothStyleValue1 = '148'; //Classic = 148
			}else if($clothStyle == 'trend'){
				$clothStyleValue1 = '149';  //Mode = 149
			}else if($clothStyle == 'sports'){
				$clothStyleValue1 = '150';  // Fun = 150
				$clothStyleValue2 = '148';  
			}else if($clothStyle == 'retro'){
				$clothStyleValue1 = '149';  
			}else if($clothStyle == 'casual'){
				$clothStyleValue1 = '148';
				$clothStyleValue1 = '149';
			}else if($clothStyle == 'eccentric'){
				$clothStyleValue1 = '150'; 
			}
			
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
			}else if($face == 'round'){
				$faceValue5 = '131'; //Round = 131
				$faceValue6 = '132'; //Square = 132
				$faceValue2 = '133'; //Butterfly = 133
				$faceValue7 = '135'; //Wayfarer = 135
			}else if($face == 'square'){
				$faceValue4 = '130'; //Oval = 130
				$faceValue5 = '131'; //Round = 131
				$faceValue2 = '133'; //Butterfly = 133
				$faceValue3 = '134'; //Half-moon = 134
			}

			 //$collection->addAttributeToFilter('gender', array($gen,36));
			 //$collection->addAttributeToFilter('gender', array('like' => '%36%'));
						//->addAttributeToFilter('style', array($clothStyleValue1));
            
			//$collection->getSelect()->where("gender" like '%66%');
			//$collection->load(true);
			
			/*$allowedSchools = array(
			  array(
				"finset" => array(36)
			  ),
			  array(
				"finset" => array(65)
			  ),
			);
			$allowedSchools1 = array(
			  array(
				"finset" => array(148)
			  ),
			  array('attribute'=>'gender','eq'=>'65'),
			);
			$collection->addAttributeToFilter("style", $allowedSchools1)->addAttributeToFilter("gender", $allowedSchools);
			*/
		}
		
		$allowedSchools = array(
			  array(
				"finset" => array(36)
			  ),
			  array(
				"finset" => array(65)
			  ),
			);
		
		$collection->addAttributeToFilter('gender',array(array("finset" => array(36)),array("finset" => array(65)),))
				   ->addAttributeToFilter('style', array('eq' => '148'));
		
	/*	$collection->addFieldToFilter(
				array(
					array('attribute'=> 'gender','eq' => $gen),
					array('attribute'=> 'gender','eq' => '36'),
					array('attribute'=> 'style','eq' => $clothStyleValue1),
					array('attribute'=> 'style','eq' => $clothStyleValue2),
					//array('attribute'=> 'shape','eq' => $faceValue1),
					//array('attribute'=> 'shape','eq' => $faceValue2),
					// array('attribute'=> 'shape','eq' => $faceValue3),
					// array('attribute'=> 'shape','eq' => $faceValue4),
					// array('attribute'=> 'shape','eq' => $faceValue5),
					// array('attribute'=> 'shape','eq' => $faceValue6),
					// array('attribute'=> 'shape','eq' => $faceValue7),
				)
			);
		*/
		//$collection->addAttributeToFilter('price', array('eq' => '10'))->addAttributeToFilter('price', array('eq' => '20'));
		
		//if($clearData == 'clear'){
		//	Mage::getSingleton('core/session')->clear();
		//}else{
		//	$collection->addAttributeToFilter('price', array('gteq' => Mage::getSingleton('core/session')->getPriceLowerLimit()))
		//				->addAttributeToFilter('gender', array('eq' => Mage::getSingleton('core/session')->getGender()))
		//				->addAttributeToFilter('frame_shape', array('eq' => Mage::getSingleton('core/session')->getshape()))
		//				->addAttributeToFilter('price', array('lteq' => Mage::getSingleton('core/session')->getPriceUpperLimit()));
		//}
		// insert start       
		//	$collection->addAttributeToFilter('price', array('gteq' => 10));
		// insert end 
		
        // set collection to toolbar and apply sort
        $toolbar->setCollection($collection);

        $this->setChild('toolbar', $toolbar);
        Mage::dispatchEvent('catalog_block_product_list_collection', array(
            'collection' => $this->_getProductCollection()
        ));

        $this->_getProductCollection()->load();
		echo $this->_getProductCollection()->load();
        return parent::_beforeToHtml();
    }
	
/*	
	protected function _beforeToHtml()
	{
		  $toolbar = $this->getToolbarBlock();
		  // called prepare sortable parameters
		  $collection = $this->_getProductCollection();
		  // use sortable parameters
		  $orders = $this->getAvailableOrders();
		  //insert a sort by new field "Newest"
		  $orders = array_merge($orders, array('entity_id'=>$this->__('Newest'),
					'rating_summary'=>$this->__('Rating')));
		  $toolbar->setAvailableOrders($orders);
		  $toolbar->setDefaultOrder('entity_id');
		  $toolbar->setDefaultDirection('desc');
		  if ($modes = $this->getModes()) {
		   $toolbar->setModes($modes);
		  }
		  // set collection to tollbar and apply sort
		  $toolbar->setCollection($collection);
		  $this->setChild('toolbar', $toolbar);
		  Mage::dispatchEvent('catalog_block_product_list_collection', array(
		   'collection'=>$this->_getProductCollection(),
		  ));
		  $this->_getProductCollection()->load();
		  Mage::getModel('review/review')->appendSummary($this->_getProductCollection());
		  return parent::_beforeToHtml();
	}
*/	
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
