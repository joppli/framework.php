<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class AssociativeArrayValidator
{
  public function validate($input, string $key = '')
  {
    if(!is_array($input))
      return false;

    $keys     = array_keys($input);
    $filtered = array_filter($keys, 'is_string');
    $count    = count($filtered);

    if(!(bool)$count)
      throw new ValidatorException(($key ? $key : 'input') . ' MUST be an associative array');
  }
}
