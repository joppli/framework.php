<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class Bit32IntegerValidator
{
  public function validate(int $input, string $key = '')
  {
    if($input > 2147483647)
      throw new ValidatorException(
        ($key ? $key : 'input') . ' MUST NOT be greater then a 32 bit integer');
  }
}
