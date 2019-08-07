<?php

class My_Object_Provider
{
    private $id_provider;
    private $name;
    private $address;
    private $cp;
    private $phone;
    private $created;
    private $updated;

    public function getIdProvider()
    {
      return $this->id_provider;
    }

    public function setIdProvider($id_provider)
    {
      $this->id_provider = $id_provider;
    }

    public function getName()
    {
      return $this->name;
    }

    public function setName($name)
    {
      $this->name = $name;
    }

    public function getAddress()
    {
      return $this->address;
    }

    public function setAddress($address)
    {
      $this->address = $address;
    }

    public function getCp()
    {
      return $this->cp;
    }

    public function setCp($cp)
    {
      $this->cp = $cp;
    }

    public function getPhone()
    {
      return $this->phone;
    }

    public function setPhone($phone)
    {
      $this->phone = $phone;
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

    public function populate($data)
    {
      if (isset($data["id_provider"]))
          $this->setIdProvider($data["id_provider"]);
      if (isset($data["name"]))
          $this->setName($data["name"]);
      if (isset($data["address"]))
          $this->setAddress($data["address"]);
      if (isset($data["cp"]))
          $this->setCp($data["cp"]);
      if (isset($data["phone"]))
          $this->setPhone($data["phone"]);
      if (isset($data["created"]))
          $this->setCreated($data["created"]);
      if (isset($data["update"]))
          $this->setUpdated($data["update"]);
      return $this;
    }

    public function toArray()
    {
      $data = array();
      if (isset($this->id_provider))
          $data ["id_provider"] = $this->getIdProvider();
      if (isset($this->name))
          $data ["name"] = $this->getName();
      if (isset($this->address))
          $data ["address"] = $this->getAddress();
      if (isset($this->cp))
          $data ["cp"] = $this->getCp();
      if (isset($this->phone))
          $data ["phone"] = $this->getPhone();
      if (isset($this->created))
          $data ["created"] = $this->getCreated();
      if (isset($this->updated))
          $data ["updated"] = $this->getUpdated();
      return $data;
    }

    public function populateEdit($data)
    {
      if (isset($data["name"]))
          $this->setName($data["name"]);
      if (isset($data["address"]))
          $this->setAddress($data["address"]);
      if (isset($data["cp"]))
          $this->setCp($data["cp"]);
      if (isset($data["phone"]))
          $this->setPhone($data["phone"]);
      return $this;
    }

}
