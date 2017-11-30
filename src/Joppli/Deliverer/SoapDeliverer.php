<?php

namespace Joppli\Deliverer;

use
SoapFault,
SoapServer,
Joppli\Builder\Aware\BuilderAware,
Joppli\Builder\Aware\BuilderAwareTrait,
Joppli\Request\Aware\RequestAware,
Joppli\Request\Aware\RequestAwareTrait;

class SoapDeliverer extends AbstractDeliverer
implements RequestAware, BuilderAware
{
  use
  BuilderAwareTrait,
  RequestAwareTrait;

  protected function composeOutput(array $entity) : string
  {
    $obj = is_string($entity['soap'])
         ? $this->builder->build($entity['soap'])
         : $entity['soap'];

    $server = new SoapServer(null, ['uri' =>  $this->request->getUri()]);
    $server->setObject($obj);
    $server->handle();
    return '';
  }
}
