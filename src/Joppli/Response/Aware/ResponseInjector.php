<?php

namespace Joppli\Response\Aware;

use
  Joppli\Builder\Injector,
  Joppli\Response\Response;

class ResponseInjector implements Injector
{
  private $response;

  public function inject($instance)
  {
    if($instance instanceof ResponseAware)
      $instance->setResponse($this->getResponse());
  }

  protected function getResponse() : Response
  {
    if(!$this->response)
      $this->response = new Response;

    return $this->response;
  }
}