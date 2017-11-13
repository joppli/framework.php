<?php

namespace Joppli\Deliverer;

use
Joppli\Response\Aware\ResponseAware,
Joppli\Response\Aware\ResponseAwareTrait,
Joppli\Response\ResponseService;

abstract class AbstractDeliverer implements Deliverer, ResponseAware
{
  use ResponseAwareTrait;

  private $service;

  public function __construct(ResponseService $service)
  {
    $this->service = $service;
  }

  public function deliver()
  {
    foreach ($this->response->getHeaders() as $header)
      $this->service->addHeader($header);

    $this->service->setStatus($this->response->getStatus());

    $output = $this->composeOutput($this->response->getAttributes());
    $this->service->output($output);
  }

  abstract protected function composeOutput(array $entity) : string;
}
