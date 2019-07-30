<?php

/**
*	@brief		My_Controller_Action_API
*	@include	Zend_Controller_Action
*/
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;

class My_Controller_Action_API extends Zend_Controller_Action{
    /**
    *	@post	Se configuran el modulo, action y controlador a utilizar
    */
    public function init(){
    }

}
