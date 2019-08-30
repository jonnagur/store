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
    $select->where("send.id_user =?", $id_user);

    return $select->query()->fetchAll();
  }

  public function getSendByUserAndDateStartEnd($id_user, $date_start, $date_end)
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("send");

    if ($date_start)
    {
      $select->where("date(created) >=?", $date_start);
    }

    if ($date_end)
    {
      $select->where("date(created) <=?", $date_end);
    }

    $select->where("send.id_user =?", $id_user);

    return $select->query()->fetchAll();
  }

  public function getArticlesBySend($id_send) {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("send", array());
    $select->join("line_send", "line_send.id_send = send.id_send");
    $select->join("article", "article.id_article = line_send.id_article", array("name as name_article"));
    $select->where("line_send.id_send =?", $id_send);

    return $select->query()->fetchAll();
  }

  public function validateParams($data)
  {
    $error = 0;
    if (!isset($data['id_origin_warehouse']))
      $error = 1;
    if (!isset($data['id_destination_warehouse']))
      $error = 1;
    if (!isset($data['articles']))
      $error = 1;

    if ($error)
    {
      return 0;
    }

    if (empty($data['articles']))
    {
      return 4;
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

  public function getSendByCode($code)
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("send");
    $select->where("code =?", $code);

    return $select->query()->fetchAll();
  }

  public function generateCode() {
    $length = 15;
    // $code = md5(uniqid(rand(), true));

    $characters = My_String::CHARACTERS;

    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++)
    {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    $code = $randomString;
    $issetCode = $this->getSendByCode($code);

    $ite = 0;

    while($ite < 10)
    {
      if (empty($issetCode))
      {
        return $code;
      }

      $ite++;
    }

    return array();
  }



}
