<?php
 
class Mypackage_Mymod_Model_Mysql4_Family extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('mymod/family', 'family_id');
    }
}