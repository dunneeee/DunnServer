<?php

namespace DunnServer\Http;

use DunnServer\Utils\DunnMap;

class Request
{
  /**
   * @var DunnMap<string>
   */
  protected $query;

  /**
   * @var DunnMap<mixed>
   */
  protected $params;

  function __construct()
  {
    $this->query = new DunnMap($_GET);
    $this->params = new DunnMap();
  }

  function server($key = null, $default = null)
  {
    $map = new DunnMap($_SERVER);
    if ($key) {
      return $map->get($key, $default);
    }

    return $map;
  }

  function getMethod()
  {
    return $this->server('REQUEST_METHOD');
  }

  function getUri()
  {
    return $this->server('REQUEST_URI');
  }

  function getHeaders($key = null)
  {
    $map = new DunnMap(getallheaders());
    if ($key) {
      return $map->get($key);
    }
    return $map;
  }

  function getQuery($key = null)
  {
    if ($key)
      return $this->query->get($key);
    return $this->query;
  }

  /**
   * @param string $key
   * @param string $value
   */
  function setQuery($key, $value)
  {
    $this->query->set($key, $value);
  }


  function getBody($key = null)
  {
    $returnData = new DunnMap();
    if ($this->getMethod() == 'POST') {
      $returnData->merge(new DunnMap($_POST));
    }

    $data = file_get_contents('php://input');
    $dataDecode = json_decode($data, true);
    if ($dataDecode) {
      $returnData->merge(new DunnMap($dataDecode));
    } else {
      $returnData->set('data', $data);
    }
    if ($key)
      return $returnData->get($key);
    return $returnData;
  }

  function getParams($key = null)
  {
    return $key ? $this->params->get($key) : $this->params;
  }

  /**
   * @param string $key
   * @param mixed $value
   */
  function setParams($key, $value)
  {
    $this->params->set($key, $value);
  }
}
