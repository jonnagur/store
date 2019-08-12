<?php

class API_Model_Subcategory extends My_Model_API
{
  public function __construct()
  {
    $this->dbTable = new My_DbTable_Subcategory();
  }

  public function getAllSubcategory()
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("subcategory");

    return $select->query()->fetchAll();
  }

  public function addSubcategory(My_Object_Subcategory $subcategory)
  {
    return $this->dbTable->insert($subcategory->toArray());
  }

  public function editSubcategory($id_subcategory , My_Object_Subcategory $subcategory)
  {
    return $this->dbTable->update($subcategory->toArray(), "id_subcategory = $id_subcategory");
  }

  public function getSubcategoryByIdOBJECT($id_subcategory)
  {
    $row = $this->dbTable->fetchRow("id_subcategory = $id_subcategory");
    $subcategory = new My_Object_Subcategory();

    if (!empty($row))
    {
      $result = $subcategory->populate($row->toArray());
    }
    else
    {
      $result = array();
    }

    return $result;
  }

  public function deleteSubcategory($id_subcategory)
  {
    return $this->dbTable->delete("id_subcategory = $id_subcategory");
  }

  public function validateParams($data)
  {
    $error = 0;
    if (!isset($data['name']))
      $error = 1;
    if (!isset($data['id_category']))
      $error = 1;

    if ($error) {
      return 0;
    }

    $categoryModel = new API_Model_Category();
    $category = $categoryModel->getCategoryByIdOBJECT($data['id_category']);

    if (empty($category)) {
      return 2;
    }

    return 1;
  }

}
