<?php
// ini_set('display_errors', 0);
// ini_set('max_execution_time', 300);
// ini_set('memory_limit', '512M');
/**
 *	@brief		API_CompanyController
 *	@include	Zend_Rest_Controller
 *	@details	This class implements the services to be consumed by the accounting enterprise
 */

class API_CompanyController extends Zend_Rest_Controller
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
      if (My_Validate_API::getCod() != '200') {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_CODE);
      }

      $data = $this->getRequest()->getParams();
      $data = array_map('trim', $data);

      if (My_Validate_API::getRole() !=  My_String::ROLE_SUPER_ADMIN && My_Validate_API::getRole() != My_String::ROLE_ADMIN) {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_PERMISSION_DENIED);
      }

      $companyModel = new API_Model_Company();
      $new_company = new My_Object_Company();

      $validate = $companyModel->validateParams($data);

      if (!$validate) {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_PARAMS);
      }

      $new_company->populate($data);

      try {
        $companyModel->addCompany($new_company);
      } catch (Exception $e) {
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
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_CODE);

      $data = $this->getRequest()->getParams();
      $body = $this->getRequest()->getRawBody();

      $data = array_map('trim', $data);
      $body = (array)json_decode($body);

      if (!isset($data['id'])) {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_PARAMS);
      }

      $probeModel = new API_Model_Probe();

      $edit_sonda = $probeModel->getProbeByIdOBJECT($data['id']);

      if (empty($edit_sonda)) {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_RESOURCE_NOT_FOUND);
      }

      $edit_sonda->populateEdit($body);

      try {
        $probeModel->editProbe($data['id'], $edit_sonda);
      } catch (Exception $e) {
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
     * [ip]/api/probe/gasId/{id} : devuelve las sondas que pertenecen a la gasolinera {id}
     * [ip]/api/probe/tankCompartmentId/{id_tankcompartment} : devuelve las sondas que pertenecen al compartimento {id_tankcompartment}
     * [ip]/api/probe/ : devuelve todas las sondas
     * @return [type] [description]
     */
    public function getAction()
    {
      if (My_Validate_API::getCod() != '200')
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_CODE);

      if (My_Validate_API::getRole() !=  My_String::ROLE_SUPER_ADMIN && My_Validate_API::getRole() != My_String::ROLE_ADMIN)
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_PERMISSION_DENIED);

      $data = $this->getRequest()->getParams();
      $data = array_map('trim', $data);

      $sondaModel = new API_Model_Probe();

      if (isset($data['gasId'])) {
        $sondas = $sondaModel->getAllProbeByGasId($data['gasId']);
      }elseif (isset($data['tankCompartmentId'])) {
        $sondas = $sondaModel->getAllProbeByTankCompartmentId($data['tankCompartmentId']);
      }else {
        $sondas = $sondaModel->getAllProbe();
      }

      if (empty($sondas)) {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_RESOURCE_NOT_FOUND);
      }

      return My_Response::_handleCodeResponse("200", $sondas);
    }

}