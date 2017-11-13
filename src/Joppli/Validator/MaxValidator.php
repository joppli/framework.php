<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class MaxValidator
{
  public function validate($input, int $max, string $key = '')
  {
    if($input > $max)
      throw new ValidatorException(
        ($key ? $key : 'input') . ' MUST NOT be greater then: ' . $max);
  }
}
