<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class NotEmptyValidator
{
  public function validate($input)
  {
    if($input === null || $input === '')
      throw new ValidatorException('input MUST NOT be empty');
  }
}
