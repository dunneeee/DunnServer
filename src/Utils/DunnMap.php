<?php

namespace DunnServer\Utils;

/**
 * @template T
 */
class DunnMap
{
  /**
   * @var array<string, T>
   */
  private $map = [];
  /**
   * @param array<string, T> $map
   */
  public function __construct(array $map = [])
  {
    $this->map = $map;
  }

  function toArray()
  {
    return $this->map;
  }

  /**
   * @return array<string>
   */
  function keys()
  {
    return array_keys($this->map);
  }

  /**
   * @return array<T>
   */
  function values()
  {
    return array_values($this->map);
  }

  /**
   * @param string $key
   * @param T $value
   */
  function set($key, $value)
  {
    $this->map[$key] = $value;
  }

  /**
   * @param string $key
   * @param T $default
   * @return T | null
   */
  function get($key, $default = null)
  {
    return $this->map[$key] ?? $default;
  }

  function remove($key)
  {
    unset($this->map[$key]);
  }

  function clear()
  {
    $this->map = [];
  }

  /**
   * @param DunnMap<T> $map
   */
  function merge($map)
  {
    $this->map = array_merge($this->map, $map->toArray());
  }

}
