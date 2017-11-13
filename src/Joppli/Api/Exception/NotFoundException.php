<?php

namespace Joppli\Api\Exception;

class NotFoundException extends \Exception implements HttpException
{
  public function __construct($message = 'Not Found')
  {
    parent::__construct($message, 404);
  }
}
