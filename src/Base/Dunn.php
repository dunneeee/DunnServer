<?php

namespace DunnServer\Base;

use DunnServer\Http\Request;
use DunnServer\Http\Response;
use DunnServer\Middlewares\Filter;
use DunnServer\MVC\Controller;
use DunnServer\Router\Route;
use DunnServer\Router\RouteStore;
use DunnServer\Utils\DunnArray;
use DunnServer\Utils\DunnMap;

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

  /**
   * @var \DunnServer\Utils\DunnMap<\DunnServer\Utils\DunnArray<\DunnServer\Middlewares\Filter>>
   */
  protected $filters;

  function __construct()
  {
    $this->routes = new DunnArray();
    $this->req = new Request();
    $this->res = new Response();
    $this->filters = new DunnMap();
  }

  /**
   * @param string $pattern
   * @param \DunnServer\MVC\Controller $controller;
   */
  function addRoute($pattern, $controller)
  {
    if ($controller instanceof Controller) {
      if (strlen($pattern) > 1 && str_ends_with($pattern, '/'))
        $pattern = substr($pattern, 0, strlen($pattern) - 1);
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
    } else
      throw new \Exception('The second params is class extends class `Controller`');
  }

  /**
   * @param string $pattern
   * @param \DunnServer\Middlewares\Filter $filters;
   */
  protected function loadFilter()
  {
    $patterns = $this->filters->keys();
    $patterns->forEach(function ($pattern) {
      $filters = $this->filters->get($pattern);
      if ($filters) {
        $this->routes->forEach(function (Route $route) use ($pattern, $filters) {
          $isAll = str_ends_with($pattern, '/*');
          $isMatch = $isAll ? str_starts_with($route->getPattern(), substr($pattern, 0, -2)) : $route->getPattern() == $pattern;
          if ($isMatch) {
            if ($isAll) {
              $route->getStore()->getFilterChain()->unshift(...$filters->toArray());
            } else {
              $route->getStore()->getFilterChain()->push(...$filters->toArray());
            }
          }
        });
      }
    });
    return $this;
  }

  /**
   * @param string $pattern
   * @param \DunnServer\Middlewares\Filter $filters;
   */
  function addFilter($pattern, ...$filters)
  {
    $arr = new DunnArray(...$filters);
    $arr = $arr->filter(function ($filter) {
      return $filter instanceof Filter;
    });
    $this->filters->set($pattern, $arr);
  }

  function getFilters()
  {
    return $this->filters;
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

  /**
   * @param \DunnServer\Router\Router $router
   */
  function useRouter($router)
  {
    $router->loadFilter();
    $routes = $router->getRoutes();
    $routes->forEach(function (Route $route) use ($router) {
      $pattern = $router->getPattern() . $route->getPattern();
      $this->addRoute($pattern, $route->getStore()->getController());
      $this->addFilter($pattern, ...$route->getStore()->getFilterChain()->getFilters()->toArray());
    });
    return $this;
  }

}
