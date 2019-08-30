<?php

class API_Model_Linesend extends My_Model_API
{
  public function __construct()
  {
    $this->dbTable = new My_DbTable_Linesend();
  }

  public function getAllLinesSend()
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("line_send");

    return $select->query()->fetchAll();
  }

  public function addLineSend(My_Object_Linesend $line_send)
  {
    return $this->dbTable->insert($line_send->toArray());
  }

  public function editLineSend($id_line_send , My_Object_Linesend $line_send)
  {
    return $this->dbTable->update($line_send->toArray(), "id_line_send = $id_line_send");
  }

  public function getLineSendByIdOBJECT($id_line_send)
  {
    $row = $this->dbTable->fetchRow("id_line_send = $id_line_send");
    $line_send = new My_Object_Linesend();

    if (!empty($row))
    {
      $result = $line_send->populate($row->toArray());
    }
    else
    {
      $result = array();
    }

    return $result;
  }

  public function deleteLineSend($id_line_send)
  {
    return $this->dbTable->delete("id_line_send = $id_line_send");
  }

}
