<?php

namespace Joppli\Dispatcher\Exception;

class NotFoundException extends \Exception implements HttpException
{
  public function __construct($message = 'Not Found')
  {
    parent::__construct($message, 404);
  }
}