<?php

namespace Joppli\Response\Aware;

use Joppli\Response\Response;

interface ResponseAware
{
  public function setResponse(Response $response);
}