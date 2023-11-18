<?php

namespace DunnServer\MVC;

use DunnServer\Http\HttpAction;

class Controller implements HttpAction, ControllerAction
{
  function doGet($req, $res)
  {
  }

  function doPost($req, $res)
  {

  }

  function doPut($req, $res)
  {

  }

  function doDelete($req, $res)
  {

  }

  function doPatch($req, $res)
  {

  }

  function doHead($req, $res)
  {
  }
  function doOptions($req, $res)
  {
  }

  function doAction($req, $res)
  {
    switch ($req->getMethod()) {
      case 'GET':
        $this->doGet($req, $res);
        break;
      case 'POST':
        $this->doPost($req, $res);
        break;
      case 'PUT':
        $this->doPut($req, $res);
        break;
      case 'DELETE':
        $this->doDelete($req, $res);
        break;
      case 'PATCH':
        $this->doPatch($req, $res);
        break;
      case 'HEAD':
        $this->doHead($req, $res);
        break;
      case 'OPTIONS':
        $this->doOptions($req, $res);
        break;
      default:
        break;
    }
  }
}
