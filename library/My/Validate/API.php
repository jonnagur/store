<?php

/**
*	@brief		My_Controller_Action_API
*	@include	Zend_Controller_Action
*/
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;

class My_Validate_API{

  static private $cod;
  static private $username;
  static private $id;
  static private $role;
  static private $id_tipo_zona;

  public function init(){
  }

  public function getCod()
  {
   return self::$cod;
  }

  public function setCod($cod)
  {
    self::$cod = $cod;
  }

  public function getUsername()
  {
    return self::$username;
  }

  public function setUsername($username)
  {
    self::$username = $username;
  }

  public function getId()
  {
    if( self::$id == null )
    {
      $userModel = new API_Model_User();
      $this->setId( $userModel->getUserIdByEmail( self::$username ) );
    }
    
    return self::$id;
  }

  public function setId($id)
  {
    self::$id = $id;
  }

  public function getRole()
  {
    return self::$role;
  }

  public function setRole($role)
  {
    self::$role = $role;
  }

  public function setIdTipoZona( $id_tipo_zona )
  {
    self::$id_tipo_zona = $id_tipo_zona;
  }

  public function getIdTipoZona()
  {
    return self::$id_tipo_zona;
  }

  public function validate($data){
    $jwt_authorization = $data->getRequest()->getHeader('Authorization');

    $token_jwt = self::_handleJwtToken($jwt_authorization);
    $token_jwt_array = (array)json_decode($token_jwt);

    $result = array();

    if ($token_jwt_array['cod'] == '1000') {
      $token_array = (array)$token_jwt_array['msg'];

      if (!isset($token_array['email'])) {
        return self::_handleStruct(json_encode(array("cod" => "2250", "msg" => "Token incorrecto")));
      }

      $userModel = new API_Model_User();
      $user = $userModel->getUserByUsername($token_array['email']);

      if (empty($user)) {
        return self::_handleStruct(json_encode(array("cod" => "2230", "msg" => "No se ha podido validar el usuario")));
      }
      
      if ($user[0]['status'] != 10) {
        return self::_handleStruct(json_encode(array("cod" => "2230", "msg" => "No tiene permiso para recuperar ningún recurso")));
      }

      $username     = $user[0]['username'];
      $userId       = $user[0]['userId'];
      $role         = $user[0]['roleId'];
      $id_tipo_zona = $user[0]['id_tipo_zona'];

      $result['cod']  = '200';
      $result['msg']  = $username;
      $result['id']   = $userId;
      $result['role'] = $role;

      self::setCod($result['cod']);
      self::setUsername($username);
      self::setId($userId);
      self::setRole($role);
      self::setIdTipoZona($id_tipo_zona);
    }else{
      self::_handleStruct($token_jwt);
    }
  }

  protected function _handleJwtToken($token_jwt){
    $result['token'] = "";
    $result['cod'] = "";

    if (! empty($token_jwt)) {
       try {
           $token = JWT::validateJWTAPI($token_jwt, My_String::KEY);
           $result['token'] = $token;
           $result['cod'] = 1000;
       } catch (Exception $e) {
         $result['token'] = $e->getMessage();
         $result['cod'] = 2100;
       }
    } else {
     $result['cod'] = 2200;
     $result['token'] = 'Empty token';
    }

    return self::_handleError($result['cod'], $result['token']);
  }

  protected function _handleError($error, $msg){
    $res_error['cod'] = $error;
    $res_error['msg'] = $msg;

    return json_encode($res_error);
  }

  protected function _handleStruct($struct){
    if (empty($struct)) {
        $struct = array(
            "code" => "5095",
            "msg" => "No record(s) found."
        );

        $struct = json_encode($struct);
    }

    echo $struct;
    exit();
  }
}