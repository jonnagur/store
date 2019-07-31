<?php

class Api_Model_Auth extends My_Model_API {

    public function __construct() {
        $this->dbTable = new My_DbTable_Auth();
    }

    public function getAllAuth() {
  		$select = $this->dbTable->select()->setIntegrityCheck(false);
  		$select->from("auth");

  		return $select->query()->fetchAll();
  	}

    public function getAuthByTokenAndRefresh($token, $refresh_token) {
      $select = $this->dbTable->select()->setIntegrityCheck(false);
      $select->from("auth");
      $select->where("auth.token =?", $token);
      $select->where("auth.refresh_token =?", $refresh_token);

      return $select->query()->fetchAll();
    }

    public function addAuth(My_Object_Auth $auth){
        $this->dbTable->insert($auth->toArray());
    }

    public function getAuthByIdOBJECT($id_auth){
        $auth = new My_Object_Auth();
        $row = $this->dbTable->fetchRow("id_auth = $id_auth");
        if (!empty($row)) {
          $result = $auth->populate($row->toArray());;
        }else{
          $result = array();
        }

        return $result;
    }

    public function editAuth($id_auth , My_Object_Auth $auth){
        $data = $auth->toArray();
        $this->dbTable->update($data, "id_auth = $id_auth");
    }

    public function deleteAuth($id_auth){
        $this->dbTable->delete("id_auth = $id_auth");
    }
}
