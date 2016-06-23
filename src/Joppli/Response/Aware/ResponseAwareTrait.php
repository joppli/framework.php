<?php

namespace Joppli\Response\Aware;

use Joppli\Response\Response;

trait ResponseAwareTrait
{
  /**
   * @var Response
   */
  protected $response;

  public function setResponse(Response $response)
  {
    $this->response = $response;
  }
}