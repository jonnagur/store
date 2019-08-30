<?php
// ini_set('display_errors', 0);
// ini_set('max_execution_time', 300);
// ini_set('memory_limit', '512M');
/**
 *	@brief		API_AuthController
 *	@include	Zend_Rest_Controller
 *	@details	This class implements the services to be consumed by the accounting enterprise
 */
require_once 'Jwt/JWTHelper.php';

class API_LoginController extends Zend_Rest_Controller
{

    public function init()
    {
      header('Content-Type: application/json');
      $this->getHelper('Layout')->disableLayout();
      $this->getHelper('ViewRenderer')->setNoRender();
    }

    public function postAction(){
      $auth = My_Auth::getInstance();

      $data = $this->getRequest()->getParams();

      if (!isset($data['email']) || !isset($data['password']) ) {
        return My_Response::_handleCodeResponse("400", "ERROR");
      }

      $username = $data['email'];
      $password = $data['password'];

      $authResult = $auth->login($username, $password);
      $res = $auth->getInfo();

      if ($authResult["result"]) {
        $userModel = new API_Model_User();
        $user = $userModel->getUserByIdOBJECT($res->userId);

        $result['nombre'] = $user->getFirstName();
        $result['apellido'] = $user->getLastName();
        $result['email'] = $user->getEmail();

        $time = time();
        $key = My_String::KEY;

        $time_token = $time + (60*60*24); //media hora
        $time_refresh_token = $time + (60*60*24*7);

        $token = array(
          'iat' => $time, // Tiempo que inició el token
          'exp' => $time_token, // Tiempo que expirará 1 minuto
          'data' => $result['nombre'],
          'apellido' => $result['apellido'],
          'email' => $result['email']
        );

        $jwt = JWT::encode($token, $key);

        $result['access-token'] = $jwt;

        /**generate refresh token*/
        $refresh_token = array(
          'iat' => $time, // Tiempo que inició el token
          'exp' => $time_refresh_token, //
          'data' => $result['nombre'],
          'apellido' => $result['apellido'],
          'email' => $result['email']
        );

        $jwt_refresh = JWT::encode($refresh_token, $key);

        $result['refresh-token'] = $jwt_refresh;

        /**Creo la instancia en la tabla AUTH*/
        $authModel = new API_Model_Auth();

        $new_auth = new My_Object_Auth();
        $new_auth->setToken($jwt);
        $new_auth->setRefreshToken($jwt_refresh);

        try {
          $authModel->addAuth($new_auth);
        } catch (Exception $e) {

        }

        $result_token["token"] = $jwt;

        echo json_encode($result_token);
      } else {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_USER_AND_PASSWORD_DENIED);
      }
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
      $this->_forward('get', null, null);
    }

    public function getAction(){
      $this->getResponse()->setHttpResponseCode(405);
    }

}
