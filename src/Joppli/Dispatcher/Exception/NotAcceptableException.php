<?php

namespace Joppli\Dispatcher\Exception;

class NotAcceptableException extends \Exception implements HttpException
{
  public function __construct($message = 'Not Acceptable')
  {
    parent::__construct($message, 406);
  }
}