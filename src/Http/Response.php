<?php

namespace DunnServer\Http;

class Response
{

  /**
   * @var \DunnServer\MVC\View
   */
  protected $view;

  function __construct()
  {
    $this->view = new \DunnServer\MVC\View();
  }

  /**
   * @param int $code
   */
  function status($code)
  {
    http_response_code($code);
    return $this;
  }

  /**
   * @param string $header
   * @param string $value
   */
  function setHeader($header, $value)
  {
    header("$header: $value");
  }

  function contentType($contentType)
  {
    $this->setHeader('Content-Type', $contentType);
  }

  /**
   * @param  string $str
   */
  function text($str)
  {
    $this->contentType('text/plain');
    echo $str;
  }

  /**
   * @param  string $html
   */
  function html($html)
  {
    $this->contentType('text/html');
    echo $html;
  }

  function json($data)
  {
    $this->contentType('application/json');
    echo json_encode($data);
  }

  function send($data)
  {
    if (is_object($data) || is_array($data)) {
      $this->json($data);
    } else if (is_string($data)) {
      $this->html($data);
    } else {
      $this->text($data);
    }
  }

  function redirect($url, $code = 0, $isExit = true)
  {
    if ($code) {
      http_response_code($code);
    }

    header("Location: $url");

    if ($isExit) {
      exit;
    }
  }

  /**
   * @param string | null $view
   */
  function getView($view = null)
  {
    if ($view) {
      $this->view->setName($view);
    }
    return $this->view;
  }

  /**
   * @param \DunnServer\MVC\View $newView
   */
  function setView($newView)
  {
    $this->view = $newView;
    return $this;
  }
}
