<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class NotNullValidator
{
  public function validate($input, string $key = '')
  {
    if($input === null)
      throw new ValidatorException(($key ? $key : 'input') . ' MUST NOT be null');
  }
}
