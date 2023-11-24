<?php

namespace DunnServer;

use DunnServer\Base\Dunn;

class DunnServer extends Dunn
{
  function run()
  {
    $this->loadFilter();
    $req = $this->req;
    $res = $this->res;
    $uri = $req->getUri();

    $route = $this->getRoute($uri);
    if ($route) {
      $req->getParams()->merge($route->getParams());
      $store = $route->getStore();
      $store->getFilterChain()->doFilter($req, $res);
      if ($store->getFilterChain()->isCompleted()) {
        $store->getController()->doAction($req, $res);
      }
    }
  }

  function startSession()
  {
    session_start();
  }

  function destroySession()
  {
    session_destroy();
  }
}
