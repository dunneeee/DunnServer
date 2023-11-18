<?php

namespace DunnServer\Middlewares;

interface DoFilter
{
  /**
   * @param \DunnServer\Http\Request $req
   * @param \DunnServer\Http\Response $res
   */
  function doFilter($req, $res);
}
