<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class MaxValidator
{
  public function validate($input, int $max)
  {
    if($input > $max)
      throw new ValidatorException(
        'input MUST NOT be greater then: ' . $max);
  }
}
