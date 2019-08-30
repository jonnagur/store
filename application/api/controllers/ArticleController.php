<?php
// ini_set('display_errors', 0);
// ini_set('max_execution_time', 300);
// ini_set('memory_limit', '512M');
/**
 *	@brief		API_WarehouseController
 *	@include	Zend_Rest_Controller
 *	@details	This class implements the services to be consumed by the accounting enterprise
 */

class API_ArticleController extends Zend_Rest_Controller
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

      $articleModel = new API_Model_Article();
      $new_article = new My_Object_Article();

      $validate = $articleModel->validateParams($data);

      if ($validate == 0)
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_PARAMS);
      }

      if ($validate == 2)
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_CATEGORY_NOT_FOUND);
      }

      if ($validate == 3)
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_PROVIDER_NOT_FOUND);
      }

      $new_article->populate($data);

      try
      {
        $articleModel->addArticle($new_article);
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

      $articleModel = new API_Model_Article();

      $edit_article = $articleModel->getArticleByIdOBJECT($data['id']);

      if (empty($edit_article))
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_RESOURCE_NOT_FOUND);
      }

      $edit_article->populateEdit($body);

      try
      {
        $articleModel->editArticle($data['id'], $edit_article);
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
     * [ip]/api/aricle/ : devuelve el artículo
     * [ip]/api/aricle/id_category/1/id_provider/2
     * [ip]/api/article/id_warehouse/{id}
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

      $articleModel = new API_Model_Article();
      $warehouseModel = new API_Model_Warehouse();

      if (isset($data['name']) && isset($data['id_warehouse'])) {
        $articles = $articleModel->getLikeArticleByNameAndWarehouse($data['name'], $data['id_warehouse']);
      }
      elseif (isset($data['id']))
      {
        $articles = $articleModel->getArticleById($data['id']);
      }
      elseif (isset($data['id_warehouse']))
      {
        $isValid = $warehouseModel->getWarehouseByUserAndIdWarehouse(My_Validate_API::getId(), $data['id_warehouse']);

        if (empty($isValid))
        {
          return My_Response::_handleCodeResponse("404", My_String::ERROR_MSG_PERMISSION_DENIED);
        }

        $articles = $articleModel->getAllArticlesByWarehouse($data['id_warehouse']);
      }
      elseif (isset($data['id_category']) && isset($data['id_provider']) )
      {
        $articles = $articleModel->getArticlesByCategoryAndProvider(0, $data['id_category'], $data['id_provider']);
      }
      elseif (isset($data['id_category']))
      {
        $articles = $articleModel->getArticlesByCategoryAndProvider(1, $data['id_category']);
      }
      elseif (isset($data['id_provider']))
      {
        $articles = $articleModel->getArticlesByCategoryAndProvider(2, $data['id_provider']);
      }

      if (empty($articles))
      {
        return My_Response::_handleCodeResponse("401", My_String::ERROR_MSG_RESOURCE_NOT_FOUND);
      }

      return My_Response::_handleCodeResponse("200", $articles);
    }

}
