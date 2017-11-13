<?php

namespace Joppli\Validator;

use
DateTime,
DateTimeZone,
Joppli\Validator\Exception\ValidatorException;

class DateTimeMaxMonthsAheadValidator
{
  public function validate($input, int $maxMonths, string $key = '')
  {
    try
    {
      $utc    = new DateTimeZone('UTC');
      $input  = new DateTime($input, $utc);
      $now    = new DateTime('now',  $utc);
    }
    catch(\Exception $e)
    {
      throw new ValidatorException(($key ? $key : 'input') . ' MUST be of a valid date format');
    }

    $diff   = $input->diff($now);
    $months = $diff->format('%y') * 12 + $diff->format('%m');

    if($months > $maxMonths)
      throw new ValidatorException(
        ($key ? $key : 'input') . ' MUST have a date less then '.$maxMonths
        .' month forward in time');
  }
}
