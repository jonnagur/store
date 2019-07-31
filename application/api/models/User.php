<?php

class API_Model_User extends My_Model_API {

    public function __construct() {
      $this->dbTable = new My_DbTable_User();
    }

    public function getAllUsers(){
      $select = $this->dbTable->select()->setIntegrityCheck(false);
      $select->from("user" , array("userId" , "username" , "firstName" , "lastName", "id_tipo_zona"));
      $select->join("role", "user.roleId = role.roleId" , "roleName");

      return $select->query()->fetchAll();
    }

    public function getAllUsersByTipoZona( $id_tipo_zona )
    {
      $select = $this->dbTable->select()->setIntegrityCheck(false);
      $select->from("user" , array("userId" , "email" , "firstName" , "lastName", "id_tipo_zona"));
      $select->where("id_tipo_zona = $id_tipo_zona");

      return $select->query()->fetchAll();
    }

    public function getUserById($userid){
      $select = $this->dbTable->select()->setIntegrityCheck(false);
      $select->from("user", array("userId", "firstName", "lastName", "username", "email", "roleId", "dni", "authkey", "status", "created_at", "updated_at", "tries", "deviceId", "id_tipo_zona"));
      $select->join("role", "user.roleId = role.roleId" , array("roleName", "roleId"));
      $select->where("user.userId =?", $userid);

      return $select->query()->fetchAll();
    }

    public function getUserZoneTypeById( $userId )
    {
      $select = $this->dbTable->select()->setIntegrityCheck(false);
      $select->from( "user", "id_tipo_zona" );
      $select->where( "userId = ?", $userId );

      return $select->query()->fetchAll();
    }

    public function getUserByUsername($username){
      $select = $this->dbTable->select()->setIntegrityCheck(false);
      $select->from("user", array("userId", "firstName", "lastName", "username", "email", "roleId"));
      $select->join("role", "user.roleId = role.roleId" , "roleName");
      $select->where("user.username =?", $username);

      return $select->query()->fetchAll();
    }

    public function getRoleAndZoneTypeFromUser( $userId )
    {
      $select = $this->dbTable->select()->setIntegrityCheck(false);
      $select->from( "user", [ "roleId", "id_tipo_zona" ] );
      $select->join( "role", "user.roleId = role.roleId", "roleName" );
      $select->where( "user.userId = ?", $userId );

      return $select->query()->fetchAll();
    }

    public function getUserIdByEmail( $email )
    {
      $select = $this->dbTable->select()->setIntegrityCheck(false);
      $select->from("user", "userId");
      $select->where("user.email = ?", $email);

      return $select->query()->fetchAll();
    }

    public function getUserByEmail($email){
      $select = $this->dbTable->select()->setIntegrityCheck(false);
      $select->from("user", array("userId", "firstName", "lastName", "username", "email", "roleId", "dni", "authkey", "status", "created_at", "updated_at", "tries", "deviceId", "id_tipo_zona"));
      $select->join("role", "user.roleId = role.roleId" , "roleName");
      $select->where("user.email =?", $email);

      return $select->query()->fetchAll();
    }

    public function addUser(My_Object_User $user){
      return $this->dbTable->insert($user->toArray());
    }

    public function editUser($userId , My_Object_User $user){
      return $this->dbTable->update($user->toArray(), "userId = $userId");
    }

    public function getUserByIdOBJECT($userId){
      $row = $this->dbTable->fetchRow("userId = $userId");
      $user = new My_Object_User();
      if (!empty($row)) {
        $result = $user->populate($row->toArray());
      }else {
        $result = array();
      }

      return $result;
    }

    public function getUserByNombres($nombre){
      $select = $this->dbTable->select()->setIntegrityCheck(false);
      $select->from("user");
      $select->where ('firstName LIKE ? ',$nombre);
      $select->ORwhere ('lastName LIKE ? ',$nombre);

    	return $select->query()->fetchAll();
    }

    public function changePassword($userId , $newPassword , $newSalt){
      $this->dbTable->update(array("password" => $newPassword), "userId = $userId");
      $this->dbTable->update(array("salt" => $newSalt), "userId = $userId");
    }

    public function encryptPassword($password , $salt){
      return sha1($password . $salt);
    }


    /* DEjo comentado el método porque en un principio solo se plantea que sea deshabilitado
    public function deleteUser($userId){
      return $this->dbTable->delete("userId = $userId");
    }
    */

    public function inhabilitateUser($userId){
      return $this->dbTable->update( [ "status" => My_Object_User::STATUS_DELETED ] , "userId = $userId");
    }

    public function rehabilitateUser($userId){
      return $this->dbTable->update( [ "status" => My_Object_User::STATUS_ACTIVE ] , "userId = $userId");
    }

    public function normaliza ($cadena){
      $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
      $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
      $cadena = utf8_decode($cadena);
      $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
      $cadena = strtolower($cadena);
      return utf8_encode($cadena);
    }

    public function ConvertToUTF8($text){
      $encoding = mb_detect_encoding($text, mb_detect_order(), false);

      if($encoding == "UTF-8"){
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
      }

      $out = iconv(mb_detect_encoding($text, mb_detect_order(), false), "UTF-8//IGNORE", $text);
      return $out;
    }

    /**
    * @brief Metodo para enviar correos
    * @param asunto, asunto que tendrá el correo,
    * @param destinatarios, destinatario(s) a los que se enviará el correo
    * @param contenido, contenido del correo
    * @return Nada 587 startttls
    */
    public function sendemail($asunto, $destinatarios, $contenido){
      try {
        if (!empty($destinatarios)) {
          $smtpServer = 'email-smtp.eu-west-1.amazonaws.com';
          $username1 = 'AKIAIXFXFWUB6WW5DXZA';
          $password1 = 'Anu8ye2JOPdHKvbwglssWwLuMlcLidRid7R5Gb9SKfTR';

          $config = array('ssl' => 'ssl',
                          'auth' => 'login',
                          'port' => '465',
                          'username' => $username1,
                          'password' => $password1);
          $transport = new Zend_Mail_Transport_Smtp($smtpServer, $config);

          $mail = new Zend_Mail();
          $mail->setFrom('info@petroprix.com');

          foreach ($destinatarios as $destinos) {
            $mail->addTo($destinos, $destinos);
          }

          $mail->setSubject(utf8_decode($asunto));
          $mail->addHeader('MIME-Version', '1.0');
          $mail->addHeader('Content-Transfer-Encoding', '8bit');
          $mail->addHeader('X-Mailer:', 'PHP/'.phpversion());

          $mail->setBodyHtml(utf8_decode($contenido));

          try {
            $mail->send($transport);
            return true;
          } catch (Exception $e) {
            echo "No se ha podido enviar el correo";
            return false;
          }
        }
      } catch (Exception $e) {
        return false;
      }
    }

    public function getUserByIdTipoZonaAndIdGas($id_tipo_zona, $id_gas){
      $select = $this->dbTable->select()->setIntegrityCheck(false);
      $select->from("user", array("userId", "firstName", "lastName", "username", "email", "roleId", "dni", "authkey", "status", "created_at", "updated_at", "tries", "deviceId", "id_tipo_zona"));
      $select->join("role", "user.roleId = role.roleId" , "roleName");
      $select->join("empleado_gasolinera", "empleado_gasolinera.empleadoId = user.userId", array());
      $select->join("gasolinera", "gasolinera.idgas = empleado_gasolinera.idgas", array());
      $select->where("gasolinera.idgas =?", $id_gas);
      $select->where("user.id_tipo_zona =?", $id_tipo_zona);

      return $select->query()->fetchAll();
    }

    public function getUserByIdTipoZonaAndIdZona($id_tipo_zona, $id_zona){
      $select = $this->dbTable->select()->setIntegrityCheck(false);
      $select->from("user", array("userId", "firstName", "lastName", "username", "email", "roleId", "dni", "authkey", "status", "created_at", "updated_at", "tries", "deviceId", "id_tipo_zona"));
      $select->join("role", "user.roleId = role.roleId" , "roleName");
      $select->join("empleado_zona", "empleado_zona.id_user = user.userId", array());
      $select->join("zona", "zona.zid = empleado_zona.id_zona", array());
      $select->where("zona.zid =?", $id_zona);
      $select->where("user.id_tipo_zona =?", $id_tipo_zona);

      return $select->query()->fetchAll();
    }

    public function getUserByIdTipoZona($id_tipo_zona){
      $select = $this->dbTable->select()->setIntegrityCheck(false);
      $select->from("user", array("userId", "firstName", "lastName", "username", "email", "roleId", "dni", "authkey", "status", "created_at", "updated_at", "tries", "deviceId", "id_tipo_zona"));
      $select->join("role", "user.roleId = role.roleId" , "roleName");
      $select->where("user.id_tipo_zona =?", $id_tipo_zona);
      $select->where("user.roleId =?", 4);

      return $select->query()->fetchAll();
    }


}
