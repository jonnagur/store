<?php
// ini_set('display_errors', 0);
// ini_set('max_execution_time', 300);
// ini_set('memory_limit', '512M');
/**
 *	@brief		API_WarehouseController
 *	@include	Zend_Rest_Controller
 *	@details	This class implements the services to be consumed by the accounting enterprise
 */

class API_LinesendController extends Zend_Rest_Controller
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
      return My_Response::_handleCodeResponse("404", My_String::ERROR_MSG_INVALID_CODE);

      $data = $this->getRequest()->getParams();

      $data = array_map('trim', $data);
      $body = $data;

      if (empty($body))
      {
        return My_Response::_handleCodeResponse("404", My_String::ERROR_MSG_INVALID_PARAMS);
      }

      $linesendModel = new API_Model_Linesend();
      $sendModel = new API_Model_Send();
      $warehousearticleModel = new API_Model_Warehousearticle();

      $line_update_error = array();
      $articles_array = (array)json_decode($body['articles']);

      if (empty($articles_array)) {
        return My_Response::_handleCodeResponse("404", "Todos los artículos ya han sido validados");
      }

      $id_send = $articles_array[0]->id_send;
      $id_origin_warehouse = $articles_array[0]->id_origin_warehouse;
      $id_destination_warehouse = $articles_array[0]->id_destination_warehouse;

      $existsArticlePending = 0;

      $send = $sendModel->getSendByIdOBJECT($id_send);

      $db = new My_DbTable_Warehousearticle();
      $db_transaction_send = $db->getAdapter();
      $db_transaction_send->beginTransaction();

      try
      {
        if (empty($send))
        {
          return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_PARAMS);
        }

        foreach ($articles_array as $r) {
          $r = (array)$r;

          if ($r['status'] != "pending")
          {
            continue;
          }

          if (!$r['isChecked']) {
            continue;
          }

          $existsArticlePending++;
          $line = $linesendModel->getLineSendByIdOBJECT($r['id_line_send']);

          if (empty($line))
          {
            array_push($line_update_error, array("id_line_send" => $r['id_line_send']));
            continue;
          }

          $line->setStatus("received");
          $line->setAmountReceived($line->getAmount());
          $line->setIdUser(My_Validate_API::getId());

          try
          {
            $linesendModel->editLineSend($r['id_line_send'], $line);
          }
          catch (Exception $e)
          {
            array_push($line_update_error, array("id_line_send" => $r['id_line_send']));
          }

          $warehouse_destinatio = $warehousearticleModel->getWarehousearticleByWarehouseAndArticle(0, $id_destination_warehouse, $r['id_article']);

          if (empty($warehouse_destinatio))
          {
            $new_warehouse_article = new My_Object_Warehousearticle();

            $new_warehouse_article->setIdWarehouse($id_destination_warehouse);
            $new_warehouse_article->setStock($r['amount']);
            $new_warehouse_article->setMinimumStock(0);
            $new_warehouse_article->setIdArticle($r['id_article']);

            $warehousearticleModel->addWarehousearticle($new_warehouse_article);
          }
          else
          {
            $new_warehouse_article = new My_Object_Warehousearticle();
            $new_warehouse_article->setStock($warehouse_destinatio[0]['stock'] + $r['amount']);

            $warehousearticleModel->editWarehousearticle($warehouse_destinatio[0]['id_warehouse_article'], $new_warehouse_article);
          }
        }

        if (!$existsArticlePending)
        {
          $db_transaction_send->rollBack();
          return My_Response::_handleCodeResponse("400", "Todos los artículos ya han sido recibidos");
        }

        if (count($line_update_error) == count($body))
        {
          $db_transaction_send->rollBack();
          return My_Response::_handleCodeResponse("400", "No se ha podido realizar la entrada");
        }

        $edit_status_send = "received_partial";

        $send_line_received = $sendModel->getAllArticlesPendingBySend($id_send);

        if (empty($send_line_received))
        {
          $edit_status_send = "received";
        }

        $send->setStatus($edit_status_send);

        $sendModel->editSend($id_send, $send);
      }
      catch (Exception $e)
      {
        $db_transaction_send->rollBack();
      }

      $db_transaction_send->commit();
      return My_Response::_handleCodeResponse("200", $line_update_error);
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
      $this->getResponse()->setHttpResponseCode(405);
    }

}
