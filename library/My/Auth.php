<?php

class My_Auth {

    private $authAdapter;
    private static $_instance = null;

    public function getAuthAdapter(){
        return $this->authAdapter;
    }

    public function setAuthAdapter($authAdapter){
        $this->authAdapter = $authAdapter;
    }

    public static function getInstance(){
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function __construct() {
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table_Abstract::getDefaultAdapter());
        $authAdapter->setTableName("user");
        $authAdapter->setIdentityColumn("username");
        $authAdapter->setCredentialColumn("password");
        $authAdapter->setCredentialTreatment("SHA1(CONCAT(?,salt))");

        $this->setAuthAdapter($authAdapter);
    }

    public function login($username , $password){
        $this->authAdapter->setIdentity($username)->setCredential($password);
        $authResult = $this->authAdapter->authenticate();

        $result["result"] = $authResult->isValid();

        if($result["result"]){
            $resultRow = $this->authAdapter->getResultRowObject(
                    array("username" , "userId" , "roleId", "firstName", "lastName", "email"));

            $auth = Zend_Auth::getInstance();
            $storage = $auth->getStorage();
            $storage->write($resultRow);

            $result["message"] = 1;
        } else {
            $result["message"] = "Usuario u contraseña incorrectos, intentelo de nuevo .";
        }

        return $result;
    }

    public function logout(){
        $auth = Zend_Auth::getInstance ();
        $auth->clearIdentity ();
    }

    public function isLogged(){
        $auth = Zend_Auth::getInstance();
        return $auth->hasIdentity();
    }

    public function getInfo(){
        $auth = Zend_Auth::getInstance();
        return $auth->getIdentity();
    }
}
