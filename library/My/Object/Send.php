<?php

class My_Object_Send
{
    private $id_send;
    private $id_origin_warehouse;
    private $id_destination_warehouse;
    private $status;
    private $code;
    private $id_user;
    private $created;
    private $updated;

    public function getIdSend()
    {
      return $this->id_send;
    }

    public function setIdSend($id_send)
    {
      $this->id_send = $id_send;
    }

    public function getIdOriginWarehouse()
    {
      return $this->id_origin_warehouse;
    }

    public function setIdOriginWarehouse($id_origin_warehouse)
    {
      $this->id_origin_warehouse = $id_origin_warehouse;
    }

    public function getIdDestinationWarehouse()
    {
      return $this->id_destination_warehouse;
    }

    public function setIdDestinationWarehouse($id_destination_warehouse)
    {
      $this->id_destination_warehouse = $id_destination_warehouse;
    }

    public function getStatus()
    {
      return $this->status;
    }

    public function setStatus($status)
    {
      $this->status = $status;
    }

    public function getCode()
    {
      return $this->code;
    }

    public function setCode($code)
    {
      $this->code = $code;
    }

    public function getIdUser()
    {
      return $this->id_user;
    }

    public function setIdUser($id_user)
    {
      $this->id_user = $id_user;
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
      if (isset($data["id_send"]))
          $this->setIdSend($data["id_send"]);
      if (isset($data["id_origin_warehouse"]))
          $this->setIdOriginWarehouse($data["id_origin_warehouse"]);
      if (isset($data["id_destination_warehouse"]))
          $this->setIdDestinationWarehouse($data["id_destination_warehouse"]);
      if (isset($data["status"]))
          $this->setStatus($data["status"]);
      if (isset($data["code"]))
          $this->setCode($data["code"]);
      if (isset($data["id_user"]))
          $this->setIdUser($data["id_user"]);
      if (isset($data["created"]))
          $this->setCreated($data["created"]);
      if (isset($data["updated"]))
          $this->setUpdated($data["updated"]);
      return $this;
    }

    public function toArray()
    {
      $data = array();
      if (isset($this->id_send))
          $data ["id_send"] = $this->getIdSend();
      if (isset($this->id_origin_warehouse))
          $data ["id_origin_warehouse"] = $this->getIdOriginWarehouse();
      if (isset($this->id_destination_warehouse))
          $data ["id_destination_warehouse"] = $this->getIdDestinationWarehouse();
      if (isset($this->status))
          $data ["status"] = $this->getStatus();
      if (isset($this->code))
          $data ["code"] = $this->getCode();
      if (isset($this->id_user))
          $data ["id_user"] = $this->getIdUser();
      if (isset($this->created))
          $data ["created"] = $this->getCreated();
      if (isset($this->upadted))
          $data ["upadted"] = $this->getUpdated();
      return $data;
    }

    public function populateEdit($data)
    {
      if (isset($data["id_origin_warehouse"]))
          $this->setIdOriginWarehouse($data["id_origin_warehouse"]);
      if (isset($data["id_destination_warehouse"]))
          $this->setIdDestinationWarehouse($data["id_destination_warehouse"]);
      if (isset($data["status"]))
          $this->setStatus($data["status"]);
      if (isset($data["code"]))
          $this->setCode($data["code"]);
      return $this;
    }

}
