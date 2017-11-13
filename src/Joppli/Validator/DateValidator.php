<?php

namespace Joppli\Validator;

use DateTime;

class DateValidator
{
  public function validate(string $input, string $format = 'Y-m-d')
  {
    try
    {
      $timezoneFrom   = new DateTimeZone('UTC');
      $outputDate     = new DateTime($input, $timezoneFrom);
    }
    catch(\Exception $e)
    {
      throw new ValidatorException(
        ($key ? $key : 'input') . ' "' . $input . ' is invalid for format "' . $format . '"', 0, $e);
    }

    if($input != $f) {
      throw new ValidatorException(
        ($key ? $key : 'input') . ' "' . $input . ' is invalid for format "' . $format . '"', 0, $e);
    }
  }
}
