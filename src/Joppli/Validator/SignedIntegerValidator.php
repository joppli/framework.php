<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class SignedIntegerValidator
{
  public function validate($input, string $key = '')
  {
    if(!is_numeric($input) || (int)$input != $input)
      throw new ValidatorException(($key ? $key : 'input') . ' MUST be an integer');
  }
}
