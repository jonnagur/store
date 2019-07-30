<?php

class API_Model_Role extends My_Model_API {

    const MODULE_ADMIN = 'ADMIN';

    public function __construct() {
      $this->dbTable = new My_DbTable_Role();
    }

    public function getRoleById($roleId){
      $select = $this->dbTable->select()->setIntegrityCheck(false);
      $select->from("role", array("rolePrivileges"));
      $select->where("role.roleId =?", $roleId);

      return $select->query()->fetchAll();
    }

}
