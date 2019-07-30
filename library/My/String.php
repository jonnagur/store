<?php

  class My_String {
    const KEY = '123456asdQWE!·$1wer13!·%·&!$WCEXWSXAVQE%R!·$R!W$&&//·WECWASDAWE2';

    const ERROR_MSG_INVALID_PARAMS              = 'Parámetros no válidos';
    const ERROR_MSG_RESOURCE_NOT_FOUND          = 'Recurso no encontrado';
    const ERROR_MSG_INVALID_CODE                = 'Código no válido';
    const ERROR_MSG_PERMISSION_DENIED           = 'Permiso denegado';
    const ERROR_MSG_ACTION_NOT_ALLOWED          = 'Acción no permitida';
    const ERROR_MSG_DUPLICATE_INSTANCE          = 'Instancia duplicada';
    const ERROR_MSG_UNKNOWN_ACTION              = 'Acción desconocida';
    const ERROR_MSG_USER_NOT_FOUND              = 'Usuario no encontrado';
    const ERROR_MSG_CREATE                      = 'No se ha podido crear la instancia';
    const ERROR_MSG_GASSTATION_NOT_FOUND        = 'Gasolinera no encontrada';
    const ERROR_MSG_SOLAR_PARK_NOT_FOUND        = 'Parque solar no encontrado';
    const ERROR_MSG_TANK_DATA_NOT_FOUND         = 'Tanque no encontrado';
    const ERROR_MSG_TANK_COMPARTMENT_NOT_FOUND  = 'Compartimento no encontrado';
    const ERROR_MSG_ELEMENT_NOT_FOUND           = 'Elemento no encontrado';
    const ERROR_MSG_FILE_NOT_FOUND              = 'Archivo no encontrado';
    const ERROR_MSG_FILE_UPLOAD                 = 'Error al subir el archivo';
    const ERROR_MSG_PROPERTY_ALREADY_MODIFIED   = 'La propiedad que intenta modificar ya ha sido modificada de su estado inicial al definitivo';
    const ERROR_MSG_REQUIRED_FRONT_VERSION      = 'Debe especificarse la versión del front';
    const ERROR_MSG_INVALID_FRONT_VERSION       = 'Versión de la app no válida.';
    const ERROR_MSG_UNSUPPORTED_FRONT_VERSION   = 'Su versión de la app no está soportada. Por favor, actualice. Si ya está en la última, contacte con el administrador.';

    const WARNING_MSG_INFERIOR_FRONT_VERSION    = 'Existe una nueva versión disponible de la app. Le recomendamos actualizar cuando sea posible.';
    const WARNING_MSG_SUPERIOR_FRONT_VERSION    = 'Su versión de la app es superior a la actualmente soportada.';

    const ROLE_SUPER_ADMIN = 1;
    const ROLE_ADMIN       = 2;
    const ROLE_SUPERVISOR  = 3;
    const ROLE_WORKER      = 4;

    const BASE_URL = 'http://localhost/manteniprix/public/api/';
    //const BASE_URL = 'http://localhost/api/';

    const REQUEST_GET  = 'GET';
    const REQUEST_POST = 'POST';

    // Habrá versiones inferiores de la app que no sean incompatibles con la actual, ahí radica la diferencia entre ambas variablees
    const MIN_FRONT_VERSION_SUPPORTED = 2;
    const CURRENT_FRONT_VERSION       = 2;

    const BASE_PATH_TASK = 'documents/task';

    const NAME_FILE_DOCUMENTO = 'document';

    public function getAllElments(){
      return array(
        'tanque_datos',
        'tanque_compartimento',
        'sonda',
        'tuberia',
        'corrosion',
        'surtidor',
        'probeta',
        'baja_tension',
        'extintor',
        'contraincendio',
        'registro_agua',
        'registro_descarga'
      );
    }
  }

?>
