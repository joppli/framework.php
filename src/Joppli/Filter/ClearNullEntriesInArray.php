<?php

namespace Joppli\Filter;

class ClearNullEntriesInArray
{
  public function filter($input) : array
  {
    $input = array_filter($input, function($value)
    {
      return !is_null($value);
    });

    return $input;
  }
}
