<?php

class My_Object_Linesend
{
    private $id_line_send;
    private $amount;
    private $amount_received;
    private $id_article;
    private $status;
    private $id_user;
    private $id_send;
    private $created;
    private $updated;

    public function getIdLineSend()
    {
      return $this->id_line_send;
    }

    public function setIdLineSend($id_line_send)
    {
      $this->id_line_send = $id_line_send;
    }

    public function getAmount()
    {
      return $this->amount;
    }

    public function setAmount($amount)
    {
      $this->amount = $amount;
    }

    public function getAmountReceived()
    {
      return $this->amount_received;
    }

    public function setAmountReceived($amount_received)
    {
      $this->amount_received = $amount_received;
    }

    public function getIdArticle()
    {
      return $this->id_article;
    }

    public function setIdArticle($id_article)
    {
      $this->id_article = $id_article;
    }

    public function getStatus()
    {
      return $this->status;
    }

    public function setStatus($status)
    {
      $this->status = $status;
    }

    public function getIdUser()
    {
      return $this->id_user;
    }

    public function setIdUser($id_user)
    {
      $this->id_user = $id_user;
    }

    public function getIdSend()
    {
      return $this->id_send;
    }

    public function setIdSend($id_send)
    {
      $this->id_send = $id_send;
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

    public function populate($data)
    {
      if (isset($data["id_line_send"]))
          $this->setIdLineSend($data["id_line_send"]);
      if (isset($data["amount"]))
          $this->setAmount($data["amount"]);
      if (isset($data["amount_received"]))
          $this->setAmountReceived($data["amount_received"]);
      if (isset($data["id_article"]))
          $this->setIdArticle($data["id_article"]);
      if (isset($data["status"]))
          $this->setStatus($data["status"]);
      if (isset($data["id_user"]))
          $this->setIdUser($data["id_user"]);
      if (isset($data["id_send"]))
          $this->setIdSend($data["id_send"]);
      if (isset($data["created"]))
          $this->setCreated($data["created"]);
      if (isset($data["updated"]))
          $this->setUpdated($data["updated"]);
      return $this;
    }

    public function toArray()
    {
      $data = array();
      if (isset($this->id_line_send))
          $data ["id_line_send"] = $this->getIdLineSend();
      if (isset($this->amount))
          $data ["amount"] = $this->getAmount();
      if (isset($this->amount_received))
          $data ["amount_received"] = $this->getAmountReceived();
      if (isset($this->status))
          $data ["status"] = $this->getStatus();
      if (isset($this->id_article))
          $data ["id_article"] = $this->getIdArticle();
      if (isset($this->id_user))
          $data ["id_user"] = $this->getIdUser();
      if (isset($this->id_send))
          $data ["id_send"] = $this->getIdSend();
      if (isset($this->created))
          $data ["created"] = $this->getCreated();
      if (isset($this->updated))
          $data ["updated"] = $this->getUpdated();
      return $data;
    }

}
