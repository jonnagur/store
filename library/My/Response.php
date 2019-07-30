<?php

  class My_Response {
    private $cod;
    private $msg;

    public function _handleCodeResponse($error, $msg, $error_aux = false){
      $res_error['cod'] = $error;
      $res_error['count'] = is_array($msg) ? count($msg) : 0;
      $res_error['msg'] = $msg;

      if (!empty($error_aux)) {
        $res_error['errors'] = $error_aux;
      }

      echo json_encode($res_error);
    }
  }

?>
