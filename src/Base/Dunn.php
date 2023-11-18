<?php

namespace DunnServer\Base;

use DunnServer\Http\Request;
use DunnServer\Http\Response;
use DunnServer\Router\Route;
use DunnServer\Router\RouteStore;
use DunnServer\Utils\DunnArray;

class Dunn
{
  /**
   * @var \DunnServer\Utils\DunnArray<\DunnServer\Router\Route>
   */
  protected $routes;

  /**
   * @var \DunnServer\Http\Request
   */
  protected $req;

  /**
   * @var \DunnServer\Http\Response
   */
  protected $res;

  function __construct()
  {
    $this->routes = new DunnArray();
    $this->req = new Request();
    $this->res = new Response();
  }

  /**
   * @param string $pattern
   * @param \DunnServer\MVC\Controller $controller;
   */
  function addRoute($pattern, $controller)
  {
    $index = $this->routes->findIndex(function ($route) use ($pattern) {
      return $route->getPattern() === $pattern;
    });

    if ($index != -1) {
      $this->routes->get($index)->setStore(new RouteStore($controller));
    } else {
      $route = new Route($pattern, new RouteStore($controller));
      $this->routes->push($route);
    }
    return $this;
  }

  /**
   * @param string $pattern
   * @param \DunnServer\Middlewares\Filter $filter;
   */
  function addFilter($pattern, ...$filters)
  {
    $this->routes->forEach(function (Route $route) use ($pattern, $filters) {
      $isAll = str_ends_with($pattern, '/*');
      $isMatch = $isAll ? str_starts_with($route->getPattern(), substr($pattern, 0, -2)) : $route->getPattern() == $pattern;
      if ($isMatch) {
        if ($isAll) {
          $route->getStore()->getFilterChain()->unshift(...$filters);
        } else {
          $route->getStore()->getFilterChain()->push(...$filters);
        }
      }
    });
    return $this;
  }

  function getRoute($pattern)
  {
    $index = $this->routes->findIndex(function (Route $route) use ($pattern) {
      return $route->match($pattern);
    });

    if ($index != -1) {
      return $this->routes->get($index);
    }
    return null;
  }

  function res()
  {
    return $this->res;
  }

  function req()
  {
    return $this->req;
  }

  /**
   * @param string $dir
   */
  function setViewDir($dir)
  {
    $this->res->getView()->setDir($dir);
    return $this;
  }

}
