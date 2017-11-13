<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class MinValidator
{
  public function validate($input, int $minimum)
  {
    if($input < $minimum)
      throw new ValidatorException(
        'input MUST be more then: ' . ($minimum - 1));
  }
}
