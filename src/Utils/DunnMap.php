<?php

namespace DunnServer\Utils;

/**
 * @template T
 */
class DunnMap implements \JsonSerializable
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
   * @return DunnArray<string>
   */
  function keys()
  {
    return new DunnArray(...array_keys($this->map));
  }

  /**
   * @return DunnArray<T>
   */
  function values()
  {
    return new DunnArray(...array_values($this->map));
  }

  /**
   * @param string $key
   * @param T $value
   */
  function set($key, $value)
  {
    $this->map[$key] = $value;
    return $this;
  }

  /**
   * @param string $key
   * @param T $default
   * @return T
   */
  function get($key, $default = null)
  {
    return $this->map[$key] ?? $default;
  }

  function remove($key)
  {
    unset($this->map[$key]);
    return $this;
  }

  function clear()
  {
    $this->map = [];
    return $this;
  }

  /**
   * @param DunnMap<T> $map
   */
  function merge($map)
  {
    $this->map = array_merge($this->map, $map->toArray());
    return $this;
  }

  function jsonSerialize(): mixed
  {
    return $this->map;
  }

  function length()
  {
    return count($this->map);
  }

  /**
   * @param array<string, T> $map
   */
  function setMap($map)
  {
    $this->map = $map;
    return $this;
  }

  /**
   * @param DunnMap $map
   */
  static function clone ($map)
  {
    return new DunnMap($map->toArray());
  }
}
