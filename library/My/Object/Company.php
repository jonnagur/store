<?php

class My_Object_Company
{
    private $id_company;
    private $name;
    private $address;
    private $cp;
    private $phone;
    private $cif;
    private $created;
    private $updated;
    private $mail_domain;

    public function getIdCompany()
    {
      return $this->id_company;
    }

    public function setIdCompany($id_company)
    {
      $this->id_company = $id_company;
    }

    public function getName()
    {
      return $this->name;
    }

    public function setName($name)
    {
      $this->name = $name;
    }

    public function getAddress()
    {
      return $this->address;
    }

    public function setAddress($address)
    {
      $this->address = $address;
    }

    public function getCp()
    {
      return $this->cp;
    }

    public function setCp($cp)
    {
      $this->cp = $cp;
    }

    public function getPhone()
    {
      return $this->phone;
    }

    public function setPhone($phone)
    {
      $this->phone = $phone;
    }

    public function getCif()
    {
      return $this->cif;
    }

    public function setCif($cif)
    {
      $this->cif = $cif;
    }

    public function getCreated()
    {
      return $this->created;
    }

    public function setCreated($created)
    {
      $this->created = $created;
    }

    public function getUpdated()
    {
      return $this->updated;
    }

    public function setUpdated($updated)
    {
      $this->updated = $updated;
    }

    public function getMailDomain()
    {
      return $this->mail_domain;
    }

    public function setMailDomain($mail_domain)
    {
      $this->mail_domain = $mail_domain;
    }

    public function populate($data) {
      if (isset($data["id_company"]))
          $this->setIdCompany($data["id_company"]);
      if (isset($data["name"]))
          $this->setName($data["name"]);
      if (isset($data["address"]))
          $this->setAddress($data["address"]);
      if (isset($data["cp"]))
          $this->setCp($data["cp"]);
      if (isset($data["phone"]))
          $this->setPhone($data["phone"]);
      if (isset($data["cif"]))
          $this->setCif($data["cif"]);
      if (isset($data["created"]))
          $this->setCreated($data["created"]);
      if (isset($data["updated"]))
          $this->setUpdated($data["updated"]);
      if (isset($data["mail_domain"]))
          $this->setMailDomain($data["mail_domain"]);
      return $this;
    }

    public function toArray() {
      $data = array();
      if (isset($this->id_company))
          $data ["id_company"] = $this->getIdCompany();
      if (isset($this->name))
          $data ["name"] = $this->getName();
      if (isset($this->address))
          $data ["address"] = $this->getAddress();
      if (isset($this->cp))
          $data ["cp"] = $this->getCp();
      if (isset($this->phone))
          $data ["phone"] = $this->getPhone();
      if (isset($this->cif))
          $data ["cif"] = $this->getCif();
      if (isset($this->created))
          $data ["created"] = $this->getCreated();
      if (isset($this->updated))
          $data ["updated"] = $this->getUpdated();
      if (isset($this->mail_domain))
          $data ["mail_domain"] = $this->getMailDomain();
      return $data;
    }

    public function populateEdit($data){
      if (isset($data["name"]))
          $this->setName($data["name"]);
      if (isset($data["address"]))
          $this->setAddress($data["address"]);
      if (isset($data["cp"]))
          $this->setCp($data["cp"]);
      if (isset($data["phone"]))
          $this->setPhone($data["phone"]);
      if (isset($data["cif"]))
          $this->setCif($data["cif"]);
      return $this;
    }

}
