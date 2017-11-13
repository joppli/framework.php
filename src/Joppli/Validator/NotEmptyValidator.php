<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class NotEmptyValidator
{
  public function validate($input, string $key = '')
  {
    if($input === null || $input === '')
      throw new ValidatorException(($key ? $key : 'input') . ' MUST NOT be empty');
  }
}
