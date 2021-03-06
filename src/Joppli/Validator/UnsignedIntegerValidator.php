<?php

namespace Joppli\Validator;

use Joppli\Validator\Exception\ValidatorException;

class UnsignedIntegerValidator extends SignedIntegerValidator
{
  public function validate($input)
  {
    parent::validate($input);
    if($input < 0)
      throw new ValidatorException('input MUST be unsigned');
  }
}
