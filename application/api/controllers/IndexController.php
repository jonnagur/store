<?php
// ini_set('display_errors', 0);
// ini_set('max_execution_time', 300);
// ini_set('memory_limit', '512M');
/**
 *	@brief		API_IndexController
 *	@include	Zend_Rest_Controller
 *	@details	This class implements the services to be consumed by the accounting enterprise
 */
require_once 'Jwt/JWTHelper.php';

class API_IndexController extends Zend_Rest_Controller
{

    public function init()
    {
        $this->getHelper('Layout')->disableLayout();
        $this->getHelper('ViewRenderer')->setNoRender();
        header('Content-Type: application/json');
    }

    public function postAction(){
      $data = $this->getRequest()->getParams();

      print(json_encode($data));
      // print(json_encode(array("cod" => "200", "type" => "post")));
    }

    public function putAction(){
      $this->getResponse()->setHttpResponseCode(405);
    }

    public function deleteAction(){
      $this->getResponse()->setHttpResponseCode(405);
    }

    public function headAction(){
      $this->getResponse()->setHttpResponseCode(405);
    }

    /**
     * @brief this action handle the index/list implementation of the rest webservice
     *
     * @return void
     */
    public function indexAction(){
      $result['param1'] = 'parma1';
      $result['param2'] = 'param2';
      $result['param3'] = 'param3';
      $result['param4'] = 'param4';
      $result['param5'] = 'param5';
      $result['param6'] = 'param6';
      $result['param7'] = 'param7';
      $result['param8'] = 'param8';
      $result['param9'] = array(
        "sub_param1" => "sub_param1",
        "sub_param2" => "sub_param2"
      );

      print(json_encode($result));
    }

    public function getAction(){
      print(json_encode(array("cod" => "200")));
    }

}
