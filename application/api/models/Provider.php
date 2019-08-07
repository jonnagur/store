<?php

class API_Model_Provider extends My_Model_API
{
  public function __construct()
  {
    $this->dbTable = new My_DbTable_Provider();
  }

  public function getAllProvider()
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("provider");

    return $select->query()->fetchAll();
  }

  public function addProvider(My_Object_Provider $provider)
  {
    return $this->dbTable->insert($provider->toArray());
  }

  public function editProvider($id_provider , My_Object_Provider $provider)
  {
    return $this->dbTable->update($provider->toArray(), "id_provider = $id_provider");
  }

  public function getProviderByIdOBJECT($id_provider)
  {
    $row = $this->dbTable->fetchRow("id_provider = $id_provider");
    $provider = new My_Object_Provider();

    if (!empty($row))
    {
      $result = $provider->populate($row->toArray());
    }
    else
    {
      $result = array();
    }

    return $result;
  }

  public function deleteProvider($id_provider)
  {
    return $this->dbTable->delete("id_provider = $id_provider");
  }

  public function validateParams($data)
  {
    $error = 0;
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
