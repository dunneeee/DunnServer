<?php

namespace DunnServer\Router;

class RouteStore
{
  /**
   * @var \DunnServer\MVC\ControllerAction
   */
  protected $controller;

  /**
   * @var \DunnServer\Middlewares\FilterChain
   */
  protected $filterChain;

  /**
   * @param \DunnServer\MVC\ControllerAction $controller
   * @param \DunnServer\Middlewares\FilterChain $filterChain
   */
  function __construct($controller, $filterChain = new \DunnServer\Middlewares\FilterChain())
  {
    $this->controller = $controller;
    $this->filterChain = $filterChain;
  }

  function getController()
  {
    return $this->controller;
  }

  function getFilterChain()
  {
    return $this->filterChain;
  }
}
