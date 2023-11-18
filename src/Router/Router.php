<?php

namespace DunnServer\Router;

use DunnServer\Base\Dunn;

class Router extends Dunn
{
  /**
   * @var string
   */
  protected $pattern;
  function __construct($pattern)
  {
    parent::__construct();
    $this->pattern = $pattern;
  }
  function getRoutes()
  {
    return $this->routes;
  }

  function getPattern()
  {
    return $this->pattern;
  }
}
