<?php

namespace DunnServer\Middlewares;

interface Filter
{
  /**
   * @param \DunnServer\Http\Request $req
   * @param \DunnServer\Http\Response $res
   * @param DoFilter $chain
   */
  function doFilter($req, $res, $chain);
}
