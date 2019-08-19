<?php

class API_Model_Send extends My_Model_API
{
  public function __construct()
  {
    $this->dbTable = new My_DbTable_Send();
  }

  public function getAllSend()
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("send");

    return $select->query()->fetchAll();
  }

  public function addSend(My_Object_Send $send)
  {
    return $this->dbTable->insert($send->toArray());
  }

  public function editSend($id_send , My_Object_Send $send)
  {
    return $this->dbTable->update($send->toArray(), "id_send = $id_send");
  }

  public function getSendByIdOBJECT($id_send)
  {
    $row = $this->dbTable->fetchRow("id_send = $id_send");
    $send = new My_Object_Send();

    if (!empty($row))
    {
      $result = $send->populate($row->toArray());
    }
    else
    {
      $result = array();
    }

    return $result;
  }

  public function deleteSend($id_send)
  {
    return $this->dbTable->delete("id_send = $id_send");
  }

  public function getSendByUser($id_user)
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("send");
    $select->join("user_Send", "user_Send.id_Send = Send.id_Send", array());
    $select->where("user_Send.id_user =?", $id_user);

    return $select->query()->fetchAll();
  }

  public function validateParams($data)
  {
    $error = 0;
    if (!isset($data['id_origin_warehouse']))
      $error = 1;
    if (!isset($data['id_destination_warehouse']))
      $error = 1;
    if (!isset($data['id_user']))
      $error = 1;

    if ($error)
    {
      return 0;
    }

    $warehouseModel = new API_Model_Warehouse();
    $origin_warehouse = $warehouseModel->getWarehouseByIdOBJECT($data['id_origin_warehouse']);

    if (empty($origin_warehouse))
    {
      return 2;
    }

    $destination_warehouse = $warehouseModel->getWarehouseByIdOBJECT($data['id_destination_warehouse']);

    if (empty($destination_warehouse))
    {
      return 3;
    }

    return 1;
  }

}
