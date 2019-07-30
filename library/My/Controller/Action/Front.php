<?php

class My_Controller_Action_Front extends Zend_Controller_Action {

    public function init(){
    
        $acl = My_Acl::getInstance(My_Acl::FRONT_MODULE);
        $front = Zend_Controller_Front::getInstance();
        $controller = $front->getRequest()->getControllerName();
        $action = $front->getRequest()->getActionName();
        if(! $acl->isAllowed($controller , $action)){
            $this->_redirect("/index/index/message/2");
        }    
        
    }
}
