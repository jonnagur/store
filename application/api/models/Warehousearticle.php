<?php

class API_Model_Warehousearticle extends My_Model_API
{
  public function __construct()
  {
    $this->dbTable = new My_DbTable_Warehousearticle();
  }

  public function getAllWarehousearticle()
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("warehouse_article");

    return $select->query()->fetchAll();
  }

  public function getWarehouseById($id_warehouse_article)
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("warehouse_article");
    $select->where("warehouse_article.id_warehouse_article =?", $id_warehouse_article);

    return $select->query()->fetchAll();
  }

  public function addWarehousearticle(My_Object_Warehousearticle $warehousearticle)
  {
    return $this->dbTable->insert($warehousearticle->toArray());
  }

  public function editWarehousearticle($id_warehouse_article , My_Object_Warehousearticle $warehousearticle)
  {
    return $this->dbTable->update($warehousearticle->toArray(), "id_warehouse_article = $id_warehouse_article");
  }

  public function getWarehousearticleByIdOBJECT($id_warehouse_article)
  {
    $row = $this->dbTable->fetchRow("id_warehouse_article = $id_warehouse_article");
    $warehousearticle = new My_Object_Warehousearticle();

    if (!empty($row))
    {
      $result = $warehousearticle->populate($row->toArray());
    }
    else
    {
      $result = array();
    }

    return $result;
  }

  public function deleteWarehousearticle($id_warehouse_article)
  {
    return $this->dbTable->delete("id_warehouse_article = $id_warehouse_article");
  }

  public function getWarehousearticleByWarehouseAndArticle($search, $id_warehouse = false, $id_article = false)
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("warehouse_article");

    if ($search == 0)
    {
      if (empty($id_warehouse) || empty($id_article)) return array();

      $select->where("warehouse_article.id_warehouse =?", $id_warehouse);
      $select->where("warehouse_article.id_article =?", $id_article);
    }
    elseif ($search == 1)
    {
      if (empty($id_warehouse)) return array();

      $select->where("warehouse_article.id_warehouse =?", $id_warehouse);
    }
    elseif ($search == 2)
    {
      if (empty($id_article)) return array();

      $select->where("warehouse_article.id_article =?", $id_article);
    }

    return $select->query()->fetchAll();
  }

  public function validateParams($data)
  {
    $error = 0;
    if (!isset($data['stock']))
      $error = 1;
    if (!isset($data['minimun_stock']))
      $error = 1;
    if (!isset($data['id_warehouse']))
      $error = 1;
    if (!isset($data['id_article']))
      $error = 1;

    if ($error) {
      return 0;
    }

    $warehouseModel = new API_Model_Warehouse();
    $warehouse = $warehouseModel->getWarehouseByIdOBJECT($data['id_warehouse']);

    if (empty($warehouse))
    {
      return 2;
    }

    $articleModel = new API_Model_Article();
    $article = $articleModel->getArticleByIdOBJECT($data['id_article']);

    if (empty($article))
    {
      return 3;
    }

    return 1;
  }

}
