<?php

  class My_String {
    const KEY = '123456asdQWE!·$1wer13!·%·&!$WCEXWSXAVQE%R!·$R!W$&&//·WECWASDAWE2';

    const ERROR_MSG_INVALID_PARAMS                  = 'Parámetros no válidos';
    const ERROR_MSG_RESOURCE_NOT_FOUND              = 'Recurso no encontrado';
    const ERROR_MSG_INVALID_CODE                    = 'Código no válido';
    const ERROR_MSG_PERMISSION_DENIED               = 'Permiso denegado';
    const ERROR_MSG_ACTION_NOT_ALLOWED              = 'Acción no permitida';
    const ERROR_MSG_DUPLICATE_INSTANCE              = 'Instancia duplicada';
    const ERROR_MSG_UNKNOWN_ACTION                  = 'Acción desconocida';
    const ERROR_MSG_USER_NOT_FOUND                  = 'Usuario no encontrado';
    const ERROR_MSG_CREATE                          = 'No se ha podido crear la instancia';
    const ERROR_MSG_ELEMENT_NOT_FOUND               = 'Elemento no encontrado';
    const ERROR_MSG_FILE_NOT_FOUND                  = 'Archivo no encontrado';
    const ERROR_MSG_FILE_UPLOAD                     = 'Error al subir el archivo';
    const ERROR_MSG_REQUIRED_FRONT_VERSION          = 'Debe especificarse la versión del front';
    const ERROR_MSG_INVALID_FRONT_VERSION           = 'Versión de la app no válida.';
    const ERROR_MSG_UNSUPPORTED_FRONT_VERSION       = 'Su versión de la app no está soportada. Por favor, actualice. Si ya está en la última, contacte con el administrador.';
    const ERROR_MSG_USER_AND_PASSWORD_DENIED        = 'Usuario y/o contraseña incorrectas';
    const ERROR_MSG_CATEGORY_NOT_FOUND              = 'Categoria no encontrada';
    const ERROR_MSG_PROVIDER_NOT_FOUND              = 'Proveedor no encontrado';
    const ERROR_MSG_WAREHOUSE_NOT_FOUND             = 'Almacén no encontrado';
    const ERROR_MSG_ORIGIN_WAREHOUSE_NOT_FOUND      = 'Almacén de origen no encontrado';
    const ERROR_MSG_DESTINATION_WAREHOUSE_NOT_FOUND = 'Almacén de destino no encontrado';
    const ERROR_MSG_ARTICLE_NOT_FOUND               = 'Artículo no encontrado';

    const WARNING_MSG_INFERIOR_FRONT_VERSION    = 'Existe una nueva versión disponible de la app. Le recomendamos actualizar cuando sea posible.';
    const WARNING_MSG_SUPERIOR_FRONT_VERSION    = 'Su versión de la app es superior a la actualmente soportada.';

    const CHARACTERS  = '0123456789abcdefghijklmnopqrs092u3tuvwxyzaskdhfhf9882323ABCDEFGHIJKLMNksadf9044OPQRSTUVWXYZ';

    const ROLE_SUPER_ADMIN = 1;
    const ROLE_ADMIN       = 2;
    const ROLE_SUPERVISOR  = 3;
    const ROLE_WORKER      = 4;

    const BASE_URL = 'http://localhost/store/public/api/';
    //const BASE_URL = 'http://localhost/api/';

    const REQUEST_GET  = 'GET';
    const REQUEST_POST = 'POST';

    // Habrá versiones inferiores de la app que no sean incompatibles con la actual, ahí radica la diferencia entre ambas variablees
    const MIN_FRONT_VERSION_SUPPORTED = 2;
    const CURRENT_FRONT_VERSION       = 2;

    const BASE_PATH_TASK = 'documents/task';

    const NAME_FILE_DOCUMENTO = 'document';
  }

?>
