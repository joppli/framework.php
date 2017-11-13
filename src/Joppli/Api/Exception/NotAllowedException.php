<?php

namespace Joppli\Api\Exception;

class NotAllowedException extends \Exception implements HttpException
{
  public function __construct($message = 'Forbidden')
  {
    parent::__construct($message, 403);
  }
}
