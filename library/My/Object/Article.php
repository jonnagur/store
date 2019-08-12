<?php

class My_Object_Article
{
    private $id_article;
    private $name;
    private $price;
    private $code;
    private $id_category;
    private $id_provider;
    private $created;
    private $updated;

    public function getIdArticle()
    {
      return $this->id_article;
    }

    public function setIdArticle($id_article)
    {
      $this->id_article = $id_article;
    }

    public function getName()
    {
      return $this->name;
    }

    public function setName($name)
    {
      $this->name = $name;
    }

    public function getPrice()
    {
      return $this->price;
    }

    public function setPrice($price)
    {
      $this->price = $price;
    }

    public function getCode()
    {
      return $this->code;
    }

    public function setCode($code)
    {
      $this->code = $code;
    }

    public function getIdCategory()
    {
      return $this->id_category;
    }

    public function setIdCategory($id_category)
    {
      $this->id_category = $id_category;
    }

    public function getIdProvider()
    {
      return $this->id_provider;
    }

    public function setIdProvider($id_provider)
    {
      $this->id_provider = $id_provider;
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
      if (isset($data["id_article"]))
          $this->setIdArticle($data["id_article"]);
      if (isset($data["name"]))
          $this->setName($data["name"]);
      if (isset($data["price"]))
          $this->setPrice($data["price"]);
      if (isset($data["code"]))
          $this->setCode($data["code"]);
      if (isset($data["id_category"]))
          $this->setIdCategory($data["id_category"]);
      if (isset($data["id_provider"]))
          $this->setIdProvider($data["id_provider"]);
      if (isset($data["created"]))
          $this->setCreated($data["created"]);
      if (isset($data["updated"]))
          $this->setUpdated($data["updated"]);
      return $this;
    }

    public function toArray()
    {
      $data = array();
      if (isset($this->id_article))
          $data ["id_article"] = $this->getIdArticle();
      if (isset($this->name))
          $data ["name"] = $this->getName();
      if (isset($this->price))
          $data ["price"] = $this->getPrice();
      if (isset($this->code))
          $data ["code"] = $this->getCode();
      if (isset($this->id_category))
          $data ["id_category"] = $this->getIdCategory();
      if (isset($this->id_provider))
          $data ["id_provider"] = $this->getIdProvider();
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
      if (isset($data["price"]))
          $this->setPrice($data["price"]);
      if (isset($data["code"]))
          $this->setCode($data["code"]);
      if (isset($data["id_category"]))
          $this->setIdCategory($data["id_category"]);
      if (isset($data["id_provider"]))
          $this->setIdProvider($data["id_provider"]);
      return $this;
    }

}
