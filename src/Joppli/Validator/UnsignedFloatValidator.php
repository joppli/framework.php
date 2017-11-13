<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class FloatValidator
{
  public function validate(float $input, string $key = '')
  {
    if($input < 0)
      throw new ValidatorException(($key ? $key : 'input') . ' MUST be unsigned');
  }
}
