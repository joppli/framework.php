<?php

namespace Joppli\Filter;

class BoolFilter
{
  public function filter($input)
  {
    $filter   = FILTER_VALIDATE_BOOLEAN;
    $options  = FILTER_NULL_ON_FAILURE;
    $bool     = filter_var($input, $filter, $options);

    return $bool;
  }
}
