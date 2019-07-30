<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    public function _initAutoload() {
        $autoloader = new Zend_Application_Module_Autoloader(
                        array('namespace' => 'Default',
                            'basePath' => dirname(__FILE__) . '/default',
                        )
        );

        $autoloader2 = new Zend_Application_Module_Autoloader(
                        array('namespace' => 'Admin',
                            'basePath' => dirname(__FILE__) . '/admin',
                        )
        );

        $autoloader3 = new Zend_Application_Module_Autoloader(
                        array('namespace' => 'API',
                            'basePath' => dirname(__FILE__) . '/api',
                        )
        );

        Zend_Session::start();
    }

    protected function _initLayoutHelper() {
        $this->bootstrap('frontController');
        $layout = Zend_Controller_Action_HelperBroker::addHelper(
                        new My_Controller_Action_Helper_LayoutLoader());
		$view = new Zend_View();
		$view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
    }

    protected function _initCustomErrorHandler(){
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new My_Controller_Plugin_CustomErrorHandler());
    }

    protected function _initMobileDetect(){
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new My_Controller_Plugin_MobileDetect());
    }

    protected function _initRestRoute() {
  		//getting an instance of zend front controller.
  		$frontController = Zend_Controller_Front::getInstance ();
  		//initializing a Zend_Rest_Route
      $router = $frontController->getRouter();

      $restRoute = new Zend_Rest_Route( $frontController, array(), array( 'api' ));
  		//let all actions to use Zend_Rest_Route.
  		$router->addRoute ( 'rest', $restRoute );
  	}



}
