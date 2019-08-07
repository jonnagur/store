<?php

class My_Object_Category
{
    private $id_category;
    private $name;
    private $created;
    private $updated;

    public function getIdCategory()
    {
      return $this->id_category;
    }

    public function setIdCategory($id_category)
    {
      $this->id_category = $id_category;
    }

    public function getName()
    {
      return $this->name;
    }

    public function setName($name)
    {
      $this->name = $name;
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
      if (isset($data["id_category"]))
          $this->setIdCategory($data["id_category"]);
      if (isset($data["name"]))
          $this->setName($data["name"]);
      if (isset($data["created"]))
          $this->setCreated($data["created"]);
      if (isset($data["updated"]))
          $this->setUpdated($data["updated"]);
      return $this;
    }

    public function toArray()
    {
      $data = array();
      if (isset($this->id_category))
          $data ["id_category"] = $this->getIdCategory();
      if (isset($this->name))
          $data ["name"] = $this->getName();
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
      return $this;
    }

}
