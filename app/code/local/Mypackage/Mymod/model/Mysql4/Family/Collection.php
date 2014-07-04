<?php
 
class Mypackage_Mymod_Model_Mysql4_Family_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mymod/family');
    }
}