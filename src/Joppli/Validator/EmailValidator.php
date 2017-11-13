<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class EmailValidator
{
  public function validate($input)
  {
    if(filter_var($input, FILTER_VALIDATE_EMAIL) === false)
      throw new ValidatorException('input MUST be of a valid email format');
  }
}
