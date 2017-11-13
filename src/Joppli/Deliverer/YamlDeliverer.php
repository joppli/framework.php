<?php

namespace Joppli\Deliverer;

class YamlDeliverer extends AbstractDeliverer
{
  public function deliver()
  {
    $this->response->setHeader('ContentType', 'Content-Type: text/x-yaml');
    parent::deliver();
  }

  protected function composeOutput(array $entity) : string
  {
    return yaml_emit($entity);
  }
}
