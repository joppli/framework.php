<?php

namespace Joppli\Filter;

use DateTime;

class DateFormatFilter
{
  public function filter($input, string $format)
  {
    if(empty($input))
      return null;

    try
    {
      $timestamp = strtotime($input);
      return date($format, $timestamp);
    }
    catch(\Exception $e)
    {
      return $input;
    }
  }
}
