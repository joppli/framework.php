<?php

namespace Joppli\Dispatcher\Exception;

class UnauthorizedException extends \Exception implements HttpException
{
  public function __construct($message = 'Unauthorized')
  {
    parent::__construct($message, 401);
  }
}