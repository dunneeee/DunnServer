<?php

namespace DunnServer\Utils;


class DunnFile implements \JsonSerializable
{
  protected $name;
  protected $path;
  protected $type;
  protected $size;
  protected $error;

  /**
   * @param string |null $name
   * @param string |null $path
   * @param string |null $type
   * @param int $size
   */
  function __construct($name = null, $path = null, $type = null, $size = 0, $error = 0)
  {
    $this->name = $name;
    $this->path = $path;
    $this->type = $type;
    $this->size = $size;
    $this->error = $error;
  }

  function getName()
  {
    return $this->name;
  }

  function getPath()
  {
    return $this->path;
  }

  function getType()
  {
    return $this->type;
  }

  function getSize()
  {
    return $this->size;
  }

  function getError()
  {
    return $this->error;
  }

  /**
   * @param string $name
   */
  function setName($name)
  {
    $this->name = $name;
  }

  /**
   * @param string $path
   */
  function setPath($path)
  {
    $this->path = $path;
  }

  /**
   * @param string $type
   */
  function setType($type)
  {
    $this->type = $type;
  }

  /**
   * @param int $size
   */
  function setSize($size)
  {
    $this->size = $size;
  }

  /**
   * @param int $error
   */
  function setError($error)
  {
    $this->error = $error;
  }

  function jsonSerialize(): mixed
  {
    return [
      'name' => $this->name,
      'path' => $this->path,
      'type' => $this->type,
      'size' => $this->size
    ];
  }

  function moveUploadFileTo($path)
  {
    if ($this->error !== UPLOAD_ERR_OK) {
      return false;
    }

    if (!is_uploaded_file($this->path)) {
      return false;
    }

    if (move_uploaded_file($this->path, $path)) {
      $this->path = $path;
      return true;
    }
    ;
  }

  function remove()
  {
    if (file_exists($this->path)) {
      return unlink($this->path);
    }
    return false;
  }



}
