<?php
// ini_set('display_errors', 0);
// ini_set('max_execution_time', 300);
// ini_set('memory_limit', '512M');
/**
 *	@brief		API_UserController
 *	@include	Zend_Rest_Controller
 *	@details	This class implements the services to be consumed by the accounting enterprise
 */

class API_AclController extends Zend_Rest_Controller
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
      $this->getResponse()->setHttpResponseCode(405);
    }

    public function putAction()
    {
      $this->getResponse()->setHttpResponseCode(405);
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

    public function getAction()
    {
      if (My_Validate_API::getCod() != '200')
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_CODE);

      $data = $this->getRequest()->getParams();
      $data = array_map('trim', $data);

      $roleModel = new API_Model_Role();
      $result = array();

      $role = $roleModel->getRoleById(My_Validate_API::getRole());

      if (!empty($role))
      {
        try
        {
          $role = (array)json_decode($role[0]['rolePrivileges']);
          $role = (array)$role[API_Model_Role::MODULE_ADMIN];

          if (isset($data['resourceName']) && isset($data['actionName']))
          {
            $result = $role[strtolower($data['resourceName'])];
            in_array(strtolower($data['actionName']), $result) ? $result = array("isset" => 1) : $result = array("isset" => 0);
          }
          elseif (isset($data['resourceName']))
          {
            $result = $role[strtolower($data['resourceName'])];
          }
          else
          {
            $result = $role;
          }
        }
        catch (Exception $e)
        {
          $result = array();
        }
      }

      if (empty($result)) {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_RESOURCE_NOT_FOUND);
      }

      return My_Response::_handleCodeResponse("200", $result);
    }

}
