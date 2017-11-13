<?php

namespace Joppli\Composer;

class DateTimeHashComposer extends DateTimeComposer
{
  protected
    $algorithm,
    $salt,
    $randSalt;

  public function __construct(
          string $format,
          string $timezone  = 'UTC',
          string $algorithm = 'sha1',
          string $salt      = '',
          bool   $randSalt  = false)
  {
    parent::__construct($format, $timezone);

    $this->algorithm = $algorithm;
    $this->salt      = $salt;
    $this->randSalt  = $randSalt;
  }

  public function compose()
  {
    $date = parent::compose();
    $rand = $this->randSalt
          ? mt_rand(mt_getrandmax() / 1000, mt_getrandmax())
          : '';
    $hash = hash($this->algorithm, $rand.$date.$this->salt);

    return $hash;
  }
}