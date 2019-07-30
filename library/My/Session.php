<?php

class My_Session {
    
    private $sessionName ;
    private $session ;
    
    public function getSessionName(){
        return $this->sessionName;
    }
    
    public function setSessionName($sessionName){
        $this->sessionName = $sessionName;
    }
    
    public function getSession(){
        return $this->session;
    }
    
    public function setSession($session){
        $this->session = $session;
    }
    
    public function __construct($sessionName = "EJO") {
        $this->setSessionName($sessionName);
        $this->setSession(new Zend_Session_Namespace($sessionName));
    }
    
    public function __set($name, $value) {
        $this->session->$name = $value;
    }
    
    public function __get($name) {
        return $this->session->$name;
    }
    
    public function destroySession($name){
        unset($this->session->$name);
    }
}