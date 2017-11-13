<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class NotNullValidator
{
  public function validate($input)
  {
    if($input === null)
      throw new ValidatorException('input MUST NOT be null');
  }
}
