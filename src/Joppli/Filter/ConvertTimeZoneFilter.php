<?php

namespace Joppli\Filter;

use
DateTime,
DateTimeZone;

class ConvertTimeZoneFilter
{
  public function filter($input, string $format, string $from, string $to)
  {
    if(empty($input))
      return $input;

    try
    {
      $timezoneFrom = new DateTimeZone($from);
      $outputDate   = new DateTime($input, $timezoneFrom);
      $timezoneTo   = new DateTimeZone($to);
      $outputDate->setTimeZone($timezoneTo);

      return $outputDate->format($format);
    }
    catch(\Exception $e)
    {
      return $input;
    }
  }
}
