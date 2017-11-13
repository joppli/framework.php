<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class UnsignedIntegerValidator extends SignedIntegerValidator
{
  public function validate($input, string $key = '')
  {
    parent::validate($input);
    if($input < 0)
      throw new ValidatorException(($key ? $key : 'input') . ' MUST be unsigned');
  }
}
