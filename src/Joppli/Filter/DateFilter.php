<?php

namespace Joppli\Filter;

use DateTime;

class DateFilter
{
  public function filter($input, string $format = 'Y-m-d')
  {
    if(empty($input))
      return null;

    try
    {
      $timezoneFrom   = new DateTimeZone('UTC');
      $outputDate   = new DateTime($input, $timezoneFrom);
      return $outputDate->format($format);
    }
    catch(\Exception $e)
    {
      return $input;
    }
  }
}
