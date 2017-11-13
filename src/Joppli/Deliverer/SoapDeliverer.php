<?php

namespace Joppli\Deliverer;

use
SoapFault,
SoapServer,
Joppli\Request\Aware\RequestAware,
Joppli\Request\Aware\RequestAwareTrait;

class SoapDeliverer extends AbstractDeliverer implements RequestAware
{
  use RequestAwareTrait;

  protected function composeOutput(array $entity)
  {
    $server = new SoapServer(null, ['uri' =>  $this->request->getUri()]);
    $server->setObject($entity['soap']);
    $server->handle();
    return '';
  }
}
