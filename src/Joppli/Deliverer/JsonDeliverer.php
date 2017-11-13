<?php

namespace Joppli\Deliverer;

class JsonDeliverer extends AbstractDeliverer
{
  public function deliver()
  {
    $this->response->setHeader('ContentType', 'Content-Type: application/json');
    parent::deliver();
  }

  protected function composeOutput(array $entity) : string
  {
    return json_encode($entity);
  }
}
