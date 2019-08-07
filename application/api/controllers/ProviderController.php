<?php
// ini_set('display_errors', 0);
// ini_set('max_execution_time', 300);
// ini_set('memory_limit', '512M');
/**
 *	@brief		API_ProviderController
 *	@include	Zend_Rest_Controller
 *	@details	This class implements the services to be consumed by the accounting enterprise
 */

class API_ProviderController extends Zend_Rest_Controller
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

      $providerModel = new API_Model_Provider();
      $new_provider = new My_Object_Provider();

      $validate = $providerModel->validateParams($data);

      if (!$validate)
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_PARAMS);
      }

      $new_provider->populate($data);

      try
      {
        $providerModel->addProvider($new_provider);
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

      $providerModel = new API_Model_Provider();

      $edit_provider = $providerModel->getProviderByIdOBJECT($data['id']);

      if (empty($edit_provider))
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_RESOURCE_NOT_FOUND);
      }

      $edit_provider->populateEdit($body);

      try
      {
        $providerModel->editProvider($data['id'], $edit_provider);
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
     * [ip]/api/provider/ : devuelve el proveedor
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

      $providerModel = new API_Model_Provider();

      if (isset($data['id']))
      {
        $provider = $providerModel->getProviderByIdOBJECT($data['id']);
      }

      if (empty($provider))
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_RESOURCE_NOT_FOUND);
      }

      return My_Response::_handleCodeResponse("200", $provider->toArray());
    }

}
