<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class AssociativeArrayValidator
{
  public function validate($input)
  {
    if(!is_array($input))
      return false;

    $keys     = array_keys($input);
    $filtered = array_filter($keys, 'is_string');
    $count    = count($filtered);

    if(!(bool)$count)
      throw new ValidatorException('input MUST be an associative array');
  }
}
