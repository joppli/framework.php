<?php

namespace Joppli\Api\Exception;

class ConflictException extends \Exception implements HttpException
{
  public function __construct($message = 'Conflict')
  {
    parent::__construct($message, 409);
  }
}
