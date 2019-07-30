<?php

class My_Object_User {

    private $userId;
    private $firstName;
    private $lastName;
    private $username;
    private $password;
    private $salt;
    private $email;
    private $roleId;
    private $dni;
    private $authkey;
    private $status;
    private $created_at;
    private $updated_at;
    private $tries;
    private $deviceId;
    private $id_tipo_zona;

    public const ROLE_SUPER_ADMIN =  1;
    public const ROLE_ADMIN       =  2;
    public const ROLE_SUPERVISOR  =  3;
    public const ROLE_WORKER      =  4;

    public const STATUS_ACTIVE    = 10;
    public const STATUS_DELETED   =  0;

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setRoleId($roleId) {
        $this->roleId = $roleId;
    }

    public function getRoleId() {
        return $this->roleId;
    }


    public function getDni()
    {
     return $this->dni;
    }

    public function setDni($dni)
    {
     $this->dni = $dni;
    }

    public function getAuthkey()
    {
     return $this->authkey;
    }

    public function setAuthkey($authkey)
    {
     $this->authkey = $authkey;
    }

    public function getStatus()
    {
     return $this->status;
    }

    public function setStatus($status)
    {
     $this->status = $status;
    }

    public function getCreatedAt()
    {
     return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
     $this->created_at = $created_at;
    }

    public function getUpdatedAt()
    {
     return $this->updated_at;
    }

    public function setUpdatedAt($updated_at)
    {
     $this->updated_at = $updated_at;
    }

    public function getTries()
    {
     return $this->tries;
    }

    public function setTries($tries)
    {
     $this->tries = $tries;
    }

    public function getDeviceId()
    {
     return $this->deviceId;
    }

    public function setDeviceId($deviceId)
    {
     $this->deviceId = $deviceId;
    }

    public function getIdTipoZona()
    {
     return $this->id_tipo_zona;
    }

    public function setIdTipoZona($id_tipo_zona)
    {
     $this->id_tipo_zona = $id_tipo_zona;
    }

    public function populate($data) {
      if (isset($data["userId"]))
          $this->setUserId($data["userId"]);
      if (isset($data["firstName"]))
          $this->setFirstName($data["firstName"]);
      if (isset($data["lastName"]))
          $this->setLastName($data["lastName"]);
      if (isset($data["username"]))
          $this->setUsername($data["username"]);
      if (isset($data["password"]))
          $this->setPassword($data["password"]);
      if (isset($data["salt"]))
          $this->setSalt($data["salt"]);
      if (isset($data["email"]))
          $this->setEmail($data["email"]);
      if (isset($data["roleId"]))
          $this->setRoleId($data["roleId"]);
      if (isset($data["dni"]))
          $this->setDni($data["dni"]);
      if (isset($data["authkey"]))
          $this->setAuthkey($data["authkey"]);
      if (isset($data["status"]))
          $this->setStatus($data["status"]);
      if (isset($data["created_at"]))
          $this->setCreatedAt($data["created_at"]);
      if (isset($data["updated_at"]))
          $this->setUpdatedAt($data["updated_at"]);
      if (isset($data["tries"]))
          $this->setTries($data["tries"]);
      if (isset($data["deviceId"]))
          $this->setDeviceId($data["deviceId"]);
      if (isset($data["id_tipo_zona"]))
          $this->setIdTipoZona($data["id_tipo_zona"]);
      return $this;
    }

    public function toArray() {
      $data = array();
      if (isset($this->userId))
          $data ["userId"] = $this->getUserId();
      if (isset($this->firstName))
          $data ["firstName"] = $this->getFirstName();
      if (isset($this->lastName))
          $data ["lastName"] = $this->getLastName();
      if (isset($this->username))
          $data ["username"] = $this->getUsername();
      if (isset($this->password))
          $data ["password"] = $this->getPassword();
      if (isset($this->salt))
          $data ["salt"] = $this->getSalt();
      if (isset($this->email))
          $data ["email"] = $this->getEmail();
      if (isset($this->roleId))
          $data ["roleId"] = $this->getRoleId();
      if (isset($this->dni))
          $data ["dni"] = $this->getDni();
      if (isset($this->authkey))
          $data ["authkey"] = $this->getAuthkey();
      if (isset($this->status))
          $data ["status"] = $this->getStatus();
      if (isset($this->created_at))
          $data ["created_at"] = $this->getCreatedAt();
      if (isset($this->updated_at))
          $data ["updated_at"] = $this->getUpdatedAt();
      if (isset($this->tries))
          $data ["tries"] = $this->getTries();
      if (isset($this->deviceId))
          $data ["deviceId"] = $this->getDeviceId();
      if (isset($this->id_tipo_zona))
          $data ["id_tipo_zona"] = $this->getIdTipoZona();
      return $data;
    }

    public function validate()
    {
        $isValid = false;

        $userModel = new API_Model_User();

        if( $this->firstName != null &&
            $this->lastName  != null &&
            empty( $userModel->getUserByEmail( $this->email ) ) &&
            $this->password  != null &&
            $this->roleId    != null &&
            $this->dni       != null
        )
        {
            $isValid = true;
        }

        return $isValid;
    }
}

?>
