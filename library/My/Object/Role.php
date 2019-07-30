<?php

class My_Object_Role {

    private $roleId;
    private $roleName;
    private $rolePrivileges;

    public function setRoleId($roleId) {
        $this->roleId = $roleId;
    }

    public function getRoleId() {
        return $this->roleId;
    }

    public function setRoleName($roleName) {
        $this->roleName = $roleName;
    }

    public function getRoleName() {
        return $this->roleName;
    }

    public function setRolePrivileges($rolePrivileges) {
        $this->rolePrivileges = $rolePrivileges;
    }

    public function getRolePrivileges() {
        return $this->rolePrivileges;
    }

    public function populate($data) {
        if (isset($data["roleId"]))
            $this->setRoleId($data["roleId"]);
        if (isset($data["roleName"]))
            $this->setRoleName($data["roleName"]);
        if (isset($data["rolePrivileges"]))
            $this->setRolePrivileges($data["rolePrivileges"]);
        return $this;
    }

    public function toArray() {
        $data = array();
        if (isset($this->roleId))
            $data ["roleId"] = $this->getRoleId();
        if (isset($this->roleName))
            $data ["roleName"] = $this->getRoleName();
        if (isset($this->rolePrivileges))
            $data ["rolePrivileges"] = $this->getRolePrivileges();
        return $data;
    }

}

?>