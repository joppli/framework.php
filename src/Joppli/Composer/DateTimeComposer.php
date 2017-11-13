<?php

namespace Joppli\Composer;

use
  DateTime,
  DateTimezone;

class DateTimeComposer implements ComposerInterface
{
  protected
    $format,
    $timezone;

  public function __construct(string $format, string $timezone = 'UTC')
  {
    $this->format   = $format;
    $this->timezone = $timezone;
  }

  public function compose()
  {
    $utc  = new DateTimezone($this->timezone);
    $date = new DateTime;

    $date->setTimeZone($utc);
    return $date->format($this->format);
  }
}
