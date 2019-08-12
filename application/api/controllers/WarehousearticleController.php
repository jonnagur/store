<?php
// ini_set('display_errors', 0);
// ini_set('max_execution_time', 300);
// ini_set('memory_limit', '512M');
/**
 *	@brief		API_WarehousearticleController
 *	@include	Zend_Rest_Controller
 *	@details	This class implements the services to be consumed by the accounting enterprise
 */

class API_WarehousearticleController extends Zend_Rest_Controller
{
    public function init()
    {
      header('Content-Type: application/json');
      $this->getHelper('Layout')->disableLayout();
      $this->getHelper('ViewRenderer')->setNoRender();

      My_Validate_API::validate($this);
    }

    public function postAction()
    {
      if (My_Validate_API::getCod() != '200')
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_CODE);
      }

      $data = $this->getRequest()->getParams();
      $data = array_map('trim', $data);

      if (My_Validate_API::getRole() !=  My_String::ROLE_SUPER_ADMIN && My_Validate_API::getRole() != My_String::ROLE_ADMIN)
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_PERMISSION_DENIED);
      }

      $warehousearticleModel = new API_Model_Warehousearticle();
      $new_warehousearticle = new My_Object_Warehousearticle();

      $validate = $warehousearticleModel->validateParams($data);

      if ($validate == 0)
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_PARAMS);
      }

      if ($validate == 2)
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_WAREHOUSE_NOT_FOUND);
      }

      if ($validate == 3)
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_ARTICLE_NOT_FOUND);
      }

      $new_warehousearticle->populate($data);

      try
      {
        $warehousearticleModel->addWarehouse($new_warehousearticle);
      }
      catch (Exception $e)
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_CREATE);
      }

      return My_Response::_handleCodeResponse("200", "Ok");
    }

    /**
     * [putAction description]
     * @return [type] [description]
     */
    public function putAction()
    {
      $this->getResponse()->setHttpResponseCode(405);
    }

    public function patchAction()
    {
      if (My_Validate_API::getCod() != '200')
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_CODE);
      }

      $data = $this->getRequest()->getParams();
      $body = $this->getRequest()->getRawBody();

      $data = array_map('trim', $data);
      $body = (array)json_decode($body);

      if (!isset($data['id']))
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_PARAMS);
      }

      $warehousearticleModel = new API_Model_Warehousearticle();

      $edit_warehouse_article = $warehousearticleModel->getWarehousearticleByIdOBJECT($data['id']);

      if (empty($edit_warehouse_article))
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_RESOURCE_NOT_FOUND);
      }

      $edit_warehouse_article->populateEdit($body);

      try
      {
        $warehousearticleModel->editWarehousearticle($data['id'], $edit_warehouse_article);
      }
      catch (Exception $e)
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_UNKNOWN_ACTION);
      }

      return My_Response::_handleCodeResponse("200", "Ok");
    }

    public function deleteAction()
    {
      $this->getResponse()->setHttpResponseCode(405);
    }

    public function headAction()
    {
      $this->getResponse()->setHttpResponseCode(405);
    }

    public function indexAction()
    {
      $this->_forward('get', null, null);
    }

    /**
     * [ip]/api/warehousearticle/id_warehouse/1/id_article/1
     * @return [type] [description]
     */
    public function getAction()
    {
      if (My_Validate_API::getCod() != '200')
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_CODE);
      }

      if (My_Validate_API::getRole() !=  My_String::ROLE_SUPER_ADMIN && My_Validate_API::getRole() != My_String::ROLE_ADMIN)
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_PERMISSION_DENIED);
      }

      $data = $this->getRequest()->getParams();
      $data = array_map('trim', $data);

      $warehousearticleModel = new API_Model_Warehousearticle();

      if (isset($data['id']))
      {
        $warehousearticles = $warehousearticleModel->getWarehouseById($data['id']);
      }
      elseif (isset($data['id_warehouse']) && isset($data['id_article']) )
      {
        $warehousearticles = $warehousearticleModel->getWarehousearticleByWarehouseAndArticle(0, $data['id_warehouse'], $data['id_article']);
      }
      elseif (isset($data['id_warehouse']))
      {
        $warehousearticles = $warehousearticleModel->getWarehousearticleByWarehouseAndArticle(1, $data['id_warehouse']);
      }
      elseif (isset($data['id_article']))
      {
        $warehousearticles = $warehousearticleModel->getWarehousearticleByWarehouseAndArticle(2, $data['id_article']);
      }

      if (empty($warehousearticles))
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_RESOURCE_NOT_FOUND);
      }

      return My_Response::_handleCodeResponse("200", $warehousearticles);
    }

}
