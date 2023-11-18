<?php

namespace DunnServer\Middlewares;

use DunnServer\Utils\DunnArray;

class FilterChain implements DoFilter
{
  /**
   * @var \DunnServer\Utils\DunnArray<Filter>
   */
  protected $filters;
  protected $index;

  function __construct()
  {
    $this->filters = new DunnArray();
    $this->index = 0;
  }

  /**
   * @param \DunnServer\Http\Request $req
   * @param \DunnServer\Http\Response $res
   */
  function doFilter($req, $res)
  {
    if ($this->index < $this->filters->length()) {
      $filter = $this->filters->get($this->index++);
      $filter->doFilter($req, $res, $this);
    } else {
      $this->index++;
    }
  }

  /**
   * @param \DunnServer\Middlewares\Filter[] $filter
   */
  function push(...$filters)
  {
    $this->filters->push(...$filters);
    return $this;
  }

  function unshift(...$filters)
  {
    $this->filters->unshift(...$filters);
    return $this;
  }

  function isCompleted()
  {
    return $this->index > $this->filters->length();
  }

  function isLast()
  {
    return $this->index === $this->filters->length();
  }

  function getFilters()
  {
    return $this->filters;
  }
}
