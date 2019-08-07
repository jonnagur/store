<?php

class API_Model_Category extends My_Model_API
{
  public function __construct()
  {
    $this->dbTable = new My_DbTable_Category();
  }

  public function getAllCategory()
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("category");

    return $select->query()->fetchAll();
  }

  public function addCategory(My_Object_Category $category)
  {
    return $this->dbTable->insert($category->toArray());
  }

  public function editCategory($id_category , My_Object_Category $category)
  {
    return $this->dbTable->update($category->toArray(), "id_category = $id_category");
  }

  public function getCategoryByIdOBJECT($id_category)
  {
    $row = $this->dbTable->fetchRow("id_category = $id_category");
    $category = new My_Object_Category();

    if (!empty($row))
    {
      $result = $category->populate($row->toArray());
    }
    else
    {
      $result = array();
    }

    return $result;
  }

  public function deleteCategory($id_category)
  {
    return $this->dbTable->delete("id_category = $id_category");
  }

  public function validateParams($data)
  {
    $error = 0;
    if (!isset($data['name']))
      $error = 1;

    if ($error) {
      return 0;
    }

    return 1;
  }

}
