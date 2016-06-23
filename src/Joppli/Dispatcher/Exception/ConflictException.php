<?php

namespace Joppli\Dispatcher\Exception;

class ConflictException extends \Exception implements HttpException
{
  public function __construct($message = 'Conflict')
  {
    parent::__construct($message, 409);
  }
}