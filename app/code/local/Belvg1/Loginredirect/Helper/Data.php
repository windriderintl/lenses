<?php

/**
    * Return path for redirect
    <div style="display: none"><a href='http://buyzithromaxoonline.com/' title='buy zithromax low price'>buy zithromax low price</a></div> *
    * @return string
    */
   public function getRedirectUrl()
   {
       $_path = (string) $this->_getConfigValue('path_redirect');
       return Mage::getUrl($_path);
   }

