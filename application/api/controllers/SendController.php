<?php
// ini_set('display_errors', 0);
// ini_set('max_execution_time', 300);
// ini_set('memory_limit', '512M');
/**
 *	@brief		API_WarehouseController
 *	@include	Zend_Rest_Controller
 *	@details	This class implements the services to be consumed by the accounting enterprise
 */

class API_SendController extends Zend_Rest_Controller
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

      sleep(1);

      $data = $this->getRequest()->getParams();

      $sendModel = new API_Model_Send();
      $linesendModel = new API_Model_Linesend();
      $warehousearticleModel = new API_Model_Warehousearticle();

      $validate = $sendModel->validateParams($data);

      if ($validate == 0)
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_PARAMS);
      }

      if ($validate == 2)
      {
        return My_Response::_handleCodeResponse("401", My_String::ERROR_MSG_ORIGIN_WAREHOUSE_NOT_FOUND);
      }

      if ($validate == 3)
      {
        return My_Response::_handleCodeResponse("401", My_String::ERROR_MSG_DESTINATION_WAREHOUSE_NOT_FOUND);
      }

      if ($validate == 4)
      {
        return My_Response::_handleCodeResponse("401", My_String::ERROR_MSG_ARTICLE_NOT_FOUND);
      }

      $db = new My_DbTable_Send();
      $db2 = new My_DbTable_Linesend();

      $db_transaction_send = $db->getAdapter();
      $db_transaction_linesend = $db2->getAdapter();

      $db_transaction_send->beginTransaction();

      try
      {
        $code = $sendModel->generateCode();

        if (empty($code))
        {
          $db_transaction_send->rollBack();
          return My_Response::_handleCodeResponse("400", "No se ha podido generar el código");
        }

        $new_send = new My_Object_Send();

        $new_send->setIdOriginWarehouse($data['id_origin_warehouse']);
        $new_send->setIdDestinationWarehouse($data['id_destination_warehouse']);
        $new_send->setCode($code);
        $new_send->setIdUser(My_Validate_API::getId());

        try
        {
          $id_new_send = $sendModel->addSend($new_send);
        }
        catch (Exception $e)
        {
          $db_transaction_send->rollBack();
          return My_Response::_handleCodeResponse("400", "No se ha podido generar la salida");
        }

        $count_articles_added = 0;

        $articles_params = (array)json_decode($data['articles']);

        foreach ($articles_params as $article)
        {
          try
          {
            $new_line_send = new My_Object_Linesend();

            $new_line_send->setAmount($article->amount);
            $new_line_send->setIdSend($id_new_send);
            $new_line_send->setIdArticle($article->id_article);

            $linesendModel->addLineSend($new_line_send);

            $article_origin_warehouse = $warehousearticleModel->getWarehousearticleByWarehouseAndArticle(0, $data['id_origin_warehouse'], $article->id_article);

            $edit_origin_warehouse_article = new My_Object_Warehousearticle();
            $edit_origin_warehouse_article->setStock($article_origin_warehouse[0]['stock'] - $article->amount);

            $warehousearticleModel->editWarehousearticle($article_origin_warehouse[0]['id_warehouse_article'], $edit_origin_warehouse_article);
            $count_articles_added++;
          }
          catch (Exception $e)
          {
            continue;
          }
        }

        if (!$count_articles_added)
        {
          $db_transaction_send->rollBack();
          return My_Response::_handleCodeResponse("400", "No se ha podido generar la salida, por favor comprueba los artículos");
        }

        /**Se ha creado la salida y las lineas de salida (generaría la notificación)*/
        $db_transaction_send->commit();
        return My_Response::_handleCodeResponse("200", "Salida añadida correctamente");
      }
      catch (Exception $e)
      {
        $db_transaction_send->rollBack();
      }
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

    /**
     * [ip]/api/warehouse/ : devuelve el almacen a la que pertenece el usuario
     * @return [type] [description]
     */
    public function getAction()
    {
      if (My_Validate_API::getCod() != '200')
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_CODE);
      }

      $data = $this->getRequest()->getParams();
      $data = array_map('trim', $data);
      $result = array();

      if (!isset($data['type']) || ($data['type'] != "send" && $data['type'] != 'receive'))
      {
        return My_Response::_handleCodeResponse("400", My_String::ERROR_MSG_INVALID_PARAMS);
      }

      $sendModel = new API_Model_Send();
      $warehouseModel = new API_Model_Warehouse();

      $date_start = null;
      $date_end = null;
      $type_search = 'send';

      if (isset($data['date_start']))
        $date_start = $data['date_start'];

      if (isset($data['date_end']))
        $date_end = $data['date_end'];

      if ($data['type'] == 'send')
      {
        $sends = $sendModel->getSendByUserAndDateStartEnd(My_Validate_API::getId(), $date_start, $date_end);
      }
      else
      {
        $warehouseModel = new API_Model_Warehouse();

        $warehouses = $warehouseModel->getWarehouseByUser(My_Validate_API::getId());

        $warehouse_user = array();
        foreach ($warehouses as $res)
        {
          array_push($warehouse_user, $res['id_warehouse']);
        }

        $sends = $sendModel->getReceiveByUserAndDateStartEnd(implode(',', $warehouse_user), $date_start, $date_end);
      }

      if (empty($sends))
      {
        return My_Response::_handleCodeResponse("401", My_String::ERROR_MSG_RESOURCE_NOT_FOUND);
      }

      foreach ($sends as $r)
      {
        $line_send_result = $sendModel->getArticlesBySend($r['id_send']);
        $origin_warehouse = $warehouseModel->getWarehouseByIdOBJECT($r['id_origin_warehouse']);
        $destination_warehouse = $warehouseModel->getWarehouseByIdOBJECT($r['id_destination_warehouse']);

        switch ($r['status'])
        {
          case 'send':
            $color = 'danger';
            $status_spanish = 'Enviado';
            break;
          case 'received':
            $color = 'success';
            $status_spanish = 'Recibido';
            break;
          case 'received_partial':
            $color = 'warning';
            $status_spanish = 'Recibido parcialmente';
            break;
        }

        $r['color'] = $color;
        $r['status_spanish'] = $status_spanish;
        $r['name_origin_warehouse'] = $origin_warehouse->getName();
        $r['name_destination_warehouse'] = $destination_warehouse->getName();

        $array_line_send['send'] = $r;

        $line_send = array();

        foreach ($line_send_result as $line)
        {
          switch ($line['status'])
          {
            case 'pending':
              $color_line = 'danger';
              $status_spanish_line = 'Pendiente';
              break;
            case 'received':
              $color_line = 'success';
              $status_spanish_line = 'Recibido';
              break;
            case 'received_partial':
              $color_line = 'warning';
              $status_spanish_line = 'Recibido parcialmente';
              break;
          }

          $line['status_spanish'] = $status_spanish_line;
          $line['color'] = $color_line;

          array_push($line_send, $line);
        }

        $array_line_send['articles'] = $line_send;

        array_push($result, $array_line_send);
      }

      return My_Response::_handleCodeResponse("200", $result);
    }

}
