<?php

class API_Model_Company extends My_Model_API
{
  public function __construct()
  {
    $this->dbTable = new My_DbTable_Company();
  }

  public function getAllCompanys()
  {
    $select = $this->dbTable->select()->setIntegrityCheck( false );
    $select->from("company");

    return $select->query()->fetchAll();
  }

  public function addCompany(My_Object_Company $company)
  {
    return $this->dbTable->insert($company->toArray());
  }

  public function editCompany($id_company , My_Object_Company $company)
  {
    return $this->dbTable->update($company->toArray(), "id_company = $id_company");
  }

  public function getCompanyByIdOBJECT($id_company){
    $row = $this->dbTable->fetchRow("id_company = $id_company");
    $company = new My_Object_Company();
    if (!empty($row)) {
      $result = $company->populate($row->toArray());
    }else {
      $result = array();
    }

    return $result;
  }

  public function deleteCompany($id_company)
  {
    return $this->dbTable->delete("id_company = $id_company");
  }

  public function validateParams($data)
  {
    $error = 0;
    if (!isset($data['name']))
      $error = 1;
    // if (!isset($data['address']))
    //   $error = 1;
    // if (!isset($data['cp']))
    //   $error = 1;
    // if (!isset($data['phone']))
    //   $error = 1;
    // if (!isset($data['cif']))
    //   $error = 1;

    if ($error) {
      return 0;
    }

    return 1;
  }

}
