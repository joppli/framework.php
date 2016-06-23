<?php

namespace Joppli\Transformer;

use
  DateTime,
  DateTimeZone;

class TimeZoneTransformer
{
  public function transform(
    string $date,
    string $from,
    string $to,
    string $format = 'Y-m-d H:i:s') : string
  {
    try
    {
      $timezoneFrom = new DateTimeZone($from);
      $outputDate   = new DateTime($date, $timezoneFrom);
      $timezoneTo   = new DateTimeZone($to);
      $outputDate->setTimeZone($timezoneTo);

      return $outputDate->format($format);
    }
    catch(\Exception $e)
    {
      throw new Exception\TransformerException($e->getMessage());
    }
  }
}