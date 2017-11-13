<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class MinValidator
{
  public function validate($input, int $minimum, string $key = '')
  {
    if($input < $minimum)
      throw new ValidatorException(
        ($key ? $key : 'input') . ' MUST be more then: ' . ($minimum - 1));
  }
}
