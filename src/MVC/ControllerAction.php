<?php

namespace DunnServer\MVC;

interface ControllerAction
{
  /**
   * @param \DunnServer\Http\Request $req
   * @param \DunnServer\Http\Response $res
   */
  function doAction($req, $res);
}
