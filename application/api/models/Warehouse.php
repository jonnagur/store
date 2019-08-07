<?php

class API_Model_Warehouse extends My_Model_API
{
  public function __construct()
  {
    $this->dbTable = new My_DbTable_Warehouse();
  }

  public function getAllWarehouse()
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("warehouse");

    return $select->query()->fetchAll();
  }

  public function addWarehouse(My_Object_Warehouse $warehouse)
  {
    return $this->dbTable->insert($warehouse->toArray());
  }

  public function editWarehouse($id_warehouse , My_Object_Warehouse $warehouse)
  {
    return $this->dbTable->update($warehouse->toArray(), "id_warehouse = $id_warehouse");
  }

  public function getWarehouseByIdOBJECT($id_warehouse)
  {
    $row = $this->dbTable->fetchRow("id_warehouse = $id_warehouse");
    $warehouse = new My_Object_Warehouse();
    
    if (!empty($row))
    {
      $result = $warehouse->populate($row->toArray());
    }
    else
    {
      $result = array();
    }

    return $result;
  }

  public function deleteWarehouse($id_warehouse)
  {
    return $this->dbTable->delete("id_warehouse = $id_warehouse");
  }

  public function getWarehouseByUser($id_user)
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("warehouse");
    $select->join("user_warehouse", "user_warehouse.id_warehouse = warehouse.id_warehouse", array());
    $select->where("user_warehouse.id_user =?", $id_user);

    return $select->query()->fetchAll();
  }

  public function validateParams($data)
  {
    $error = 0;
    if (!isset($data['id_warehouse']))
      $error = 1;
    if (!isset($data['name']))
      $error = 1;
    if (!isset($data['address']))
      $error = 1;
    if (!isset($data['phone']))
      $error = 1;

    if ($error) {
      return 0;
    }

    return 1;
  }

}
