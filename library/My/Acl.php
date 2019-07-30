<?php

class My_Acl {

    const ADMIN_MODULE = "ADMIN";
    const FRONT_MODULE = "FRONT";
    const API_MODULE = "API";

    const GUEST_ROLE = "guest";

    private static $_instance = null;
    private $acl;
    private $role;
    private $module;

    public function getModule(){
        return $this->module;
    }

    public function setModule($module){
        $this->module = $module;
    }

    public static function getInstance($module){
        if (null === self::$_instance) {
            self::$_instance = new self($module);
        }

        return self::$_instance;
    }

    private function __construct($module) {
        $this->setModule($module);
        $roleModel = new Admin_Model_Role();
        $resourceModel = new Admin_Model_Resource();

        $auth = My_Auth::getInstance();
        $this->acl = new Zend_Acl();

        if($auth->isLogged()){
            $userInfo = $auth->getInfo();
            $roleId = $userInfo->roleId;
            $role = $roleModel->getRoleById($roleId);
            $roleName = $role->getRoleName();
            $this->role = $roleName;
        } else {
        	$roleName = self::GUEST_ROLE;
        	$role = $roleModel->getRoleByName($roleName);
        	$this->role = $roleName;
        }


        $this->acl->addRole($roleName);
        $resources = $resourceModel->getAllResources($this->getModule());

        foreach ($resources as $row){
            $this->acl->addResource($row->getResourceName());
        }

        $rolePrivileges = Zend_Json::decode($role->getRolePrivileges());
        foreach($rolePrivileges as $key => $resources){
            if($key == $module){
            foreach($resources as $resource => $actions){
                foreach($actions as $action){
                    $this->acl->allow($roleName, $resource, $action);
                }
            }
            }
        }
    }

    public function isAllowed($resource , $action){
//        return true;
        return $this->acl->isAllowed($this->role, $resource, $action);
    }

}
