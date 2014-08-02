<?php
class ModifyCartPrice_AddPrice_Model_Observer
{
    public function modifyPrice(Varien_Event_Observer $obs)
    {
        // Get the quote item
		$custPrice = 0;
        $collection = Mage::app()->getFrontController()->getRequest()->getParams();
        foreach ($collection as $option => $value) {
			if("customPrice" == $option){
				$custPrice = $value;
			}
		}
	//	echo $custPrice;
//		$collection1 = Mage::app()->getFrontController()->getRequest()->getParams()->getPrice();
        $item = $obs->getQuoteItem();
        // Ensure we have the parent item, if it has one
        $item = ( $item->getParentItem() ? $item->getParentItem() : $item );
        // Load the custom price
        // Set the custom price
        $item->setCustomPrice($custPrice);
        $item->setOriginalCustomPrice($custPrice);
        // Enable super mode on the product.
        $item->getProduct()->setIsSuperMode(true);
    }
	public function _getPriceByItem(Mage_Sales_Model_Quote_Item $item){
            $price;
            
            //use $item to determine your custom price.
            
            return $price;
        }


}
