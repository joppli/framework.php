<?php

namespace Joppli\Api\Exception;

class InternalServerErrorException extends \Exception implements HttpException
{
  public function __construct($message = 'Internal Server Error')
  {
    parent::__construct($message, 500);
  }
}
