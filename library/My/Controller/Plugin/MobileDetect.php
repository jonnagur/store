<?php

class My_Controller_Plugin_MobileDetect extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {

        $mobileDetect = new My_Mobile_Detect();
        if ($request->getModuleName() != "m") {
            if ($mobileDetect->isMobile()) {
                $urlHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('url');
                $url = $urlHelper->url(
                        array(
                        "action" => $request->getActionName(),
                        "controller" => $request->getControllerName(), 
                        "module" => "m",
                        ) , '' , true,true
                    );
                $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
                $redirector->gotourl($url);
            }
        }
    }

}

?>
