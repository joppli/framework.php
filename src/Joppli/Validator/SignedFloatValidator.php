<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class SignedFloatValidator
{
  public function validate($input)
  {
    if(!is_numeric($input) || (float)$input != $input)
      throw new ValidatorException('input MUST be a float');
  }
}
