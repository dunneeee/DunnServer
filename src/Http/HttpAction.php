<?php

namespace DunnServer\Http;

interface HttpAction
{
  /**
   * @param Request $req
   * @param Response $res
   */
  public function doGet($req, $res);
  /**
   * @param Request $req
   * @param Response $res
   */
  public function doPost($req, $res);
  /**
   * @param Request $req
   * @param Response $res
   */
  public function doPut($req, $res);
  /**
   * @param Request $req
   * @param Response $res
   */
  public function doDelete($req, $res);
  /**
   * @param Request $req
   * @param Response $res
   */
  public function doPatch($req, $res);
  /**
   * @param Request $req
   * @param Response $res
   */
  public function doHead($req, $res);
  /**
   * @param Request $req
   * @param Response $res
   */
  public function doOptions($req, $res);
}
