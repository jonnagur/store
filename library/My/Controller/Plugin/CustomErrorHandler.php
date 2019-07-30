<?php

class My_Controller_Plugin_CustomErrorHandler extends Zend_Controller_Plugin_Abstract {
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $front = Zend_Controller_Front::getInstance();
        $errorHandler = $front->getPlugin("Zend_Controller_Plugin_ErrorHandler");
        
        $errorHandler->setErrorHandlerModule($request->getModuleName());
    }
}
?>
