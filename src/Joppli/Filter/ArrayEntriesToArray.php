<?php

namespace Joppli\Filter;

class ArrayEntriesToArray
{
  public function filter(array $input, array $attributes) : array
  {
    foreach ($attributes as $attr)
      if(isset($input[$attr]) && !is_array($input[$attr]))
        $input[$attr] = [$input[$attr]];

    return $input;
  }
}
