<?php

class My_Controller_Action_Admin extends Zend_Controller_Action {
    
    public function init(){
        $auth = My_Auth::getInstance();
        
        if(! $auth->isLogged()){
            $this->_redirect("/admin/sign/in");
        } else {
            $acl = My_Acl::getInstance(My_Acl::ADMIN_MODULE);
            $front = Zend_Controller_Front::getInstance();
            $controller = $front->getRequest()->getControllerName();
            $action = $front->getRequest()->getActionName();
            if(! $acl->isAllowed($controller , $action)){
                $this->_redirect("/admin/index/index/message/2");
            }    
        }
    }
    
}