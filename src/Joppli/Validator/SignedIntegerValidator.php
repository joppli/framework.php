<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class SignedIntegerValidator
{
  public function validate($input)
  {
    if(!is_numeric($input) || (int)$input != $input)
      throw new ValidatorException('input MUST be an integer');
  }
}
