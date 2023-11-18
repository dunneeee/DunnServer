<?php

namespace DunnServer\MVC;

class View
{
  /**
   * @var string | null
   */
  protected $dir = null;

  /**
   * @var string | null
   */
  protected $name = null;

  /**
   * @var \DunnServer\Utils\DunnMap<mixed>
   */
  protected $data;

  function __construct()
  {
    $this->data = new \DunnServer\Utils\DunnMap();
  }

  /**
   * @param string $dir
   */
  function setDir($dir)
  {
    $this->dir = $dir;
    return $this;
  }

  function getDir()
  {
    return $this->dir;
  }

  /**
   * @param string $name
   */
  function setName($name)
  {
    $this->name = $name;
    return $this;
  }

  function getName()
  {
    return $this->name;
  }

  /**
   * @param string $key
   * @param mixed $value
   */
  function set($key, $value)
  {
    $this->data->set($key, $value);
    return $this;
  }

  /**
   * @param string $key
   */
  function get($key)
  {
    return $this->data->get($key);
  }

  function remove($key)
  {
    $this->data->remove($key);
    return $this;
  }

  function render()
  {
    $path = $this->dir ? $this->dir . '/' . $this->name : $this->name;
    $path = str_replace('\\', '/', $path) . '.php';
    if (file_exists($path)) {
      extract($this->data->toArray());
      ob_start();
      include $path;
      return ob_get_clean();
    } else
      throw new \Exception("View not found: $path");
  }

}
