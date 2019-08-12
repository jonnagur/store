<?php

class My_Object_Warehousearticle
{
    private $id_warehouse_article;
    private $id_warehouse;
    private $id_article;
    private $stock;
    private $minimum_stock;
    private $created;
    private $updated;

    public function getIdWarehouseArticle()
    {
      return $this->id_warehouse_article;
    }

    public function setIdWarehouseArticle($id_warehouse_article)
    {
      $this->id_warehouse_article = $id_warehouse_article;
    }

    public function getIdWarehouse()
    {
      return $this->id_warehouse;
    }

    public function setIdWarehouse($id_warehouse)
    {
      $this->id_warehouse = $id_warehouse;
    }

    public function getIdArticle()
    {
      return $this->id_article;
    }

    public function setIdArticle($id_article)
    {
      $this->id_article = $id_article;
    }

    public function getStock()
    {
      return $this->stock;
    }

    public function setStock($stock)
    {
      $this->stock = $stock;
    }

    public function getMinimumStock()
    {
      return $this->minimum_stock;
    }

    public function setMinimumStock($minimum_stock)
    {
      $this->minimum_stock = $minimum_stock;
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
      if (isset($data["id_warehouse_article"]))
          $this->setIdWarehouseArticle($data["id_warehouse_article"]);
      if (isset($data["id_warehouse"]))
          $this->setIdWarehouse($data["id_warehouse"]);
      if (isset($data["id_article"]))
          $this->setIdArticle($data["id_article"]);
      if (isset($data["stock"]))
          $this->setStock($data["stock"]);
      if (isset($data["minimun_stock"]))
          $this->setMinimumStock($data["minimun_stock"]);
      if (isset($data["created"]))
          $this->setCreated($data["created"]);
      if (isset($data["updated"]))
          $this->setUpdated($data["updated"]);
      return $this;
    }

    public function toArray()
    {
      $data = array();
      if (isset($this->id_warehouse_article))
          $data ["id_warehouse_article"] = $this->getIdWarehouseArticle();
      if (isset($this->id_warehouse))
          $data ["id_warehouse"] = $this->getIdWarehouse();
      if (isset($this->id_article))
          $data ["id_article"] = $this->getIdArticle();
      if (isset($this->stock))
          $data ["stock"] = $this->getStock();
      if (isset($this->minimum_stock))
          $data ["minimum_stock"] = $this->getMinimumStock();
      if (isset($this->created))
          $data ["created"] = $this->getCreated();
      if (isset($this->updated))
          $data ["updated"] = $this->getUpdated();
      return $data;
    }

    public function populateEdit($data)
    {
      if (isset($data["id_warehouse"]))
          $this->setIdWarehouse($data["id_warehouse"]);
      if (isset($data["id_article"]))
          $this->setIdArticle($data["id_article"]);
      if (isset($data["stock"]))
          $this->setStock($data["stock"]);
      if (isset($data["minimun_stock"]))
          $this->setMinimumStock($data["minimun_stock"]);
      return $this;
    }

}
