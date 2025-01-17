<?php

class My_Object_Warehouse
{
    private $id_warehouse;
    private $name;
    private $address;
    private $phone;
    private $created;
    private $updated;

    public function getIdWarehouse()
    {
      return $this->id_warehouse;
    }

    public function setIdWarehouse($id_warehouse)
    {
      $this->id_warehouse = $id_warehouse;
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
      if (isset($data["id_warehouse"]))
          $this->setIdWarehouse($data["id_warehouse"]);
      if (isset($data["name"]))
          $this->setName($data["name"]);
      if (isset($data["address"]))
          $this->setAddress($data["address"]);
      if (isset($data["phone"]))
          $this->setPhone($data["phone"]);
      if (isset($data["created"]))
          $this->setCreated($data["created"]);
      if (isset($data["updated"]))
          $this->setUpdated($data["updated"]);
      return $this;
    }

    public function toArray()
    {
      $data = array();
      if (isset($this->id_warehouse))
          $data ["id_warehouse"] = $this->getIdWarehouse();
      if (isset($this->name))
          $data ["name"] = $this->getName();
      if (isset($this->address))
          $data ["address"] = $this->getAddress();
      if (isset($this->phone))
          $data ["phone"] = $this->getPhone();
      if (isset($this->created))
          $data ["created"] = $this->getCreated();
      if (isset($this->upadted))
          $data ["upadted"] = $this->getUpdated();
      return $data;
    }

    public function populateEdit($data)
    {
      if (isset($data["name"]))
          $this->setName($data["name"]);
      if (isset($data["address"]))
          $this->setAddress($data["address"]);
      if (isset($data["phone"]))
          $this->setPhone($data["phone"]);
      return $this;
    }

}
