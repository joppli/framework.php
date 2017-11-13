<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class EnumValidator
{
  public function validate($input, $enumerators)
  {
    if(!in_array($input, $enumerators))
      throw new ValidatorException(
        'input MUST be one of: ' . implode(', ', $enumerators));
  }
}
