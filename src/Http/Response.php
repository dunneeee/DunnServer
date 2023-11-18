<?php

namespace DunnServer\Http;

class Response
{
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
    $json = json_encode($data);

    if ($json) {
      $this->contentType('application/json');
      echo $json;
    } else {
      $this->html($data);
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
}
