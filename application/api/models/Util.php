<?php

class API_Model_Util extends My_Model_API
{
  public function __construct()
  {
  }

  public function callEndPoint($request, $endpoint, $verbo, $data){
    $jwt_authorization = $request->getRequest()->getHeader('Authorization');

    try {
      $client_request = new Zend_Http_Client(My_String::BASE_URL.$endpoint);

      $client_request->setHeaders(
        array('Authorization' => $jwt_authorization)
      );

      switch ($verbo) {
        case My_String::REQUEST_GET:
          $client_request->setParameterGet($data);
          $response = $client_request->request(Zend_Http_Client::GET);
        break;

        case My_String::REQUEST_POST:
          $client_request->setParameterPost($data);
          $response = $client_request->request(Zend_Http_Client::POST);
        break;
      }

      if (!isset($response)) {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_UNKNOWN_ACTION);
      }

      $response_array = (array)json_decode($response->getBody());

      return $response_array;
    } catch (Exception $e) {
      return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_UNKNOWN_ACTION);
    }
  }

  /**
   * Método para subir archivos al servidor
   * @param  [type] $file array global $_FILES
   * @param  [type] $path ruta donde se guardará el archivo
   * @param  [type] $nombre nombre del archivo. Al nombre que se pasa como parámetro se le concatenará un código aleatorio
   * @return [type] array[cod, msg]
   */
  public function uploadFile($file, $path, $nombre) {
    $response['cod'] = '';
    $response['msg'] = '';

    if (!isset($file['file']['name'])) {
      $response['cod'] = '400';
      $response['msg'] = My_String::ERROR_MSG_FILE_NOT_FOUND;

      return $response;
    }

    $nombre_task = $nombre;

    $hoy = getdate();
    $anio = date('Y');
    // $target_path = "documents/task";
    $target_path = $path;
    $cadena = basename($file['file']['name']);
    $cadena = preg_replace('[\s+]','', $cadena);
    $cadena_ext = substr($cadena, -3);
    $fecha = rand(1,999).$hoy['year'].$hoy['mon'].$hoy['mday'].$hoy['hours'].$hoy['minutes'].$hoy['seconds'];
    $cadena = $nombre_task.'_'.$fecha.'.'.$cadena_ext;
    $target_path = $target_path."/".$cadena;
    $complete_path = getcwd()."/".$target_path;

    try {
      @move_uploaded_file($file['file']['tmp_name'], $complete_path);
    } catch (Exception $e) {
      $response['cod'] = '400';
      $response['msg'] = My_String::ERROR_MSG_FILE_UPLOAD;
      $response['name_file'] = '';

      return $response;
    }

    $response['cod'] = '200';
    $response['msg'] = 'Archivo subido correctamente';
    $response['name_file'] = $cadena;

    return $response;
  }

}
