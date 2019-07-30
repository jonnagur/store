<?php

class My_Object_Auth
{
    private $id_auth;
    private $token;
    private $refresh_token;
    private $created;
    private $updated;
    private $active;

    public function getIdAuth()
    {
      return $this->id_auth;
    }

    public function setIdAuth($id_auth)
    {
      $this->id_auth = $id_auth;
    }

    public function getToken()
    {
      return $this->token;
    }

    public function setToken($token)
    {
      $this->token = $token;
    }

    public function getRefreshToken()
    {
      return $this->refresh_token;
    }

    public function setRefreshToken($refresh_token)
    {
      $this->refresh_token = $refresh_token;
    }

    public function getCreated()
    {
      return $this->created;
    }

    public function setCreated($created)
    {
      $this->created = $created;
    }

    public function getUpdated()
    {
      return $this->updated;
    }

    public function setUpdated($updated)
    {
      $this->updated = $updated;
    }

    public function getActive()
    {
      return $this->active;
    }

    public function setActive($active)
    {
      $this->active = $active;
    }


    public function populate($data) {
      if (isset($data["id_auth"]))
          $this->setIdAuth($data["id_auth"]);
      if (isset($data["token"]))
          $this->setToken($data["token"]);
      if (isset($data["refresh_token"]))
          $this->setRefreshToken($data["refresh_token"]);
      if (isset($data["created"]))
          $this->setCreated($data["created"]);
      if (isset($data["updated"]))
          $this->setUpdated($data["updated"]);
      if (isset($data["active"]))
          $this->setActive($data["active"]);
      return $this;
    }

    public function toArray() {
      $data = array();
      if (isset($this->id_auth))
          $data ["id_auth"] = $this->getIdAuth();
      if (isset($this->token))
          $data ["token"] = $this->getToken();
      if (isset($this->refresh_token))
          $data ["refresh_token"] = $this->getRefreshToken();
      if (isset($this->created))
          $data ["created"] = $this->getCreated();
      if (isset($this->updated))
          $data ["updated"] = $this->getUpdated();
      if (isset($this->active))
          $data ["active"] = $this->getActive();
      return $data;
    }

    public function populateEdit($data){
      return $this;
    }
}
