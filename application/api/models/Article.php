<?php

class API_Model_Article extends My_Model_API
{
  public function __construct()
  {
    $this->dbTable = new My_DbTable_Article();
  }

  public function getAllArticle()
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("article");

    return $select->query()->fetchAll();
  }

  public function getArticleById($id_article)
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("article");
    $select->where("article =?", $id_article);

    return $select->query()->fetchAll();
  }

  public function addArticle(My_Object_Article $article)
  {
    return $this->dbTable->insert($article->toArray());
  }

  public function editArticle($id_article , My_Object_Article $article)
  {
    return $this->dbTable->update($article->toArray(), "id_article = $id_article");
  }

  public function getArticleByIdOBJECT($id_article)
  {
    $row = $this->dbTable->fetchRow("id_article = $id_article");
    $article = new My_Object_Article();

    if (!empty($row))
    {
      $result = $article->populate($row->toArray());
    }
    else
    {
      $result = array();
    }

    return $result;
  }

  public function deleteArticle($id_article)
  {
    return $this->dbTable->delete("id_article = $id_article");
  }

  public function getArticlesByCategoryAndProvider($search, $id_category = false, $id_provider = false)
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("article");

    if (!$search)
    {
      if (empty($id_category) || empty($id_provider)) return array();

      $select->where("article.id_category =?", $id_category);
      $select->where("article.id_provider =?", $id_provider);
    }
    elseif ($search == 1)
    {
      if (empty($id_category)) return array();

      $select->where("article.id_category =?", $id_category);
    }
    elseif ($search == 2)
    {
      if (empty($id_provider)) return array();

      $select->where("article.id_provider =?", $id_provider);
    }

    return $select->query()->fetchAll();
  }

  public function getAllArticlesByWarehouse($id_warehouse)
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("article", array("name", "price", "code"));
    $select->join("category", "category.id_category = article.id_category", array("name as name_category"));
    $select->join("provider", "provider.id_provider = article.id_provider", array("name as name_provider"));
    $select->join("warehouse_article", "warehouse_article.id_article = article.id_article", array("id_warehouse_article", "stock", "minimum_stock"));
    $select->where("warehouse_article.id_warehouse =?", $id_warehouse);

    return $select->query()->fetchAll();
  }

  public function getLikeArticleByNameAndWarehouse($name, $id_warehouse)
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("article", array("id_article", "name", "price", "code"));
    $select->join("warehouse_article", "warehouse_article.id_article = article.id_article", array("id_warehouse_article", "stock", "minimum_stock"));
    $select->where("article.name LIKE ?", "%".$name."%");
    $select->where("warehouse_article.id_warehouse =?", $id_warehouse);

    return $select->query()->fetchAll();
  }

  public function validateParams($data)
  {
    $error = 0;
    if (!isset($data['name']))
      $error = 1;
    if (!isset($data['id_category']))
      $error = 1;
    if (!isset($data['id_provider']))
      $error = 1;

    if ($error)
    {
      return 0;
    }

    $categoryModel = new API_Model_Category();
    $category = $categoryModel->getCategoryByIdOBJECT($data['id_category']);

    if (empty($category))
    {
      return 2;
    }

    $providerModel = new API_Model_Provider();
    $provider = $providerModel->getProviderByIdOBJECT($data['id_provider']);

    if (empty($provider))
    {
      return 3;
    }

    return 1;
  }

}
