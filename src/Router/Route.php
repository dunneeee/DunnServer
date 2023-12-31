<?php

namespace DunnServer\Router;

use DunnServer\Utils\DunnMap;

class Route
{
  /**
   * @var string
   */
  protected $pattern;

  /**
   * @var \DunnServer\Utils\DunnMap<string>
   */
  protected $params;

  /**
   * @var \DunnServer\Router\RouteStore
   */
  protected $store;

  /**
   * @param string $pattern
   * @param \DunnServer\Router\RouteStore $store
   */
  function __construct($pattern, $store)
  {
    $this->pattern = $pattern;
    $this->params = new DunnMap();
    $this->store = $store;
  }

  function getStore()
  {
    return $this->store;
  }

  /**
   * @param \DunnServer\Router\RouteStore $store
   */
  function setStore($store)
  {
    $this->store = $store;
  }

  function getParams()
  {
    return $this->params;
  }

  function getPattern()
  {
    return $this->pattern;
  }

  /**
   * @param string $newPattern
   */
  function setPattern($newPattern)
  {
    $this->pattern = $newPattern;
  }

  /**
   * @param string $pattern
   */
  function match($uri)
  {
    $parUrl = explode('?', $uri);
    $url = $parUrl[0];
    $pattern = str_replace('/*', '(/.*)?', $this->pattern);
    $ptKey = '/\{([\w\d]+)\}/';
    $keys = array();
    preg_match_all($ptKey, $pattern, $matches);
    $pattern = str_replace('/', '\/', $pattern);
    if (count($matches) > 0) {
      foreach ($matches[0] as $match) {
        $pattern = str_replace('\/' . $match, '(?:\/([\w\d]+)?)', $pattern);
      }

      foreach ($matches[1] as $match) {
        $keys[$match] = null;
      }

      $pattern = '/^' . $pattern . '$/';
      if (preg_match($pattern, $url, $matches)) {
        array_shift($matches);
        foreach ($keys as $key => $value) {
          $this->params->set($key, array_shift($matches));
        }
        return true;
      }
    }
    return false;
  }
}
