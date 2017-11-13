<?php

namespace Joppli\Validator;

use
DateTime,
DateTimeZone,
Joppli\Validator\Exception\ValidatorException;

class DateTimeInTheFutureValidator
{
  public function validate($in)
  {
    try
    {
      $utc   = new DateTimeZone('UTC');
      $input = new DateTime($in, $utc);
      $now   = new DateTime('now',  $utc);
    }
    catch(\Exception $e)
    {
      throw new ValidatorException('input MUST be of a valid date format');
    }

    if($input < $now)
      throw new ValidatorException('input MUST be of a date in the future');
  }
}
