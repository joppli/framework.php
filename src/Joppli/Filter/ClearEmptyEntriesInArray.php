<?php

namespace Joppli\Filter;

class ClearEmptyEntriesInArray
{
  public function filter($input) : array
  {
    $input = array_filter($input, function($value)
    {
      return $value !== ''
          && $value !== []
          && !is_null($value);
    });

    return $input;
  }
}
