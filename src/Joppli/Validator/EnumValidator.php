<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class EnumValidator
{
  public function validate($input, $enumerators, string $key = '')
  {
    if(!in_array($input, $enumerators))
      throw new ValidatorException(
        ($key ? $key : 'input') . ' MUST be one of: ' . implode(', ', $enumerators));
  }
}
