<?php

namespace Joppli\Deliverer;

use
  Joppli\Builder\Aware\BuilderAware,
  Joppli\Builder\Aware\BuilderAwareTrait,
  Joppli\Route\Aware\RouteAware,
  Joppli\Route\Aware\RouteAwareTrait;

class FrontDeliverer implements Deliverer, RouteAware, BuilderAware
{
  use
    RouteAwareTrait,
    BuilderAwareTrait;

  public function deliver()
  {
    $delivery = $this->route->getDeliverer();

    if(!$delivery)
      throw new Exception\NoDeliveryDeclared;

    $this->builder->build($delivery)->deliver();
  }
}