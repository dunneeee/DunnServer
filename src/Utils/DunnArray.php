<?php

namespace DunnServer\Utils;


/**
 * @template T
 */
class DunnArray implements \JsonSerializable
{
  /**
   * @var array<T>
   */
  protected $array = [];
  /**
   * @param array<T> $value
   */
  function __construct(...$value)
  {
    $this->array = $value;
  }

  /**
   * @return T | null
   */
  function get(int $index)
  {
    if ($index < 0) {
      $index = $index + $this->length();
    }

    return $this->array[$index] ?? null;
  }

  /**
   * @param array<T> $value
   */
  function push(...$value)
  {
    array_push($this->array, ...$value);
    return $this;
  }

  /**
   * @param array<T> $value
   */
  function unshift(...$value)
  {
    array_unshift($this->array, ...$value);
    return $this;
  }

  /**
   * @param array<T> $value
   * @param int $index
   */
  function splice(int $index, ...$value)
  {
    return array_splice($this->array, $index, 0, $value);
  }

  function join(string $glue)
  {
    return implode($glue, $this->array);
  }

  function length()
  {
    return count($this->array);
  }

  function isEmpty()
  {
    return empty($this->array);
  }

  function map(callable $func)
  {
    return array_map($func, $this->array);
  }

  function reduce(callable $func, $initial = null)
  {
    return array_reduce($this->array, $func, $initial);
  }

  function forEach (callable $func)
  {
    for ($i = 0; $i < count($this->array); $i++) {
      $func($this->array[$i], $i, $this->array);
    }
    return $this;
  }

  /**
   * @return array<T>
   */
  function filter(callable $func)
  {
    return array_filter($this->array, $func);
  }

  /**
   * @return T | null
   */
  function find(callable $func)
  {
    return array_filter($this->array, $func)[0] ?? null;
  }

  /**
   * @return int
   */
  function findIndex(callable $func)
  {
    $index = -1;
    for ($i = 0; $i < count($this->array); $i++) {
      if ($func($this->array[$i], $i, $this->array)) {
        $index = $i;
        break;
      }
    }
    return $index;
  }

  /**
   * @return T
   */
  function shift()
  {
    return array_shift($this->array);
  }

  /**
   * @return T
   */
  function pop()
  {
    return array_pop($this->array);
  }

  function toArray()
  {
    return $this->array;
  }

  /**
   * @param DunnArray<T> $array
   */
  function merge($array)
  {
    return array_merge($this->array, $array->toArray());
  }

  function jsonSerialize(): mixed
  {
    return $this->array;
  }
}
