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

    $class    = __NAMESPACE__.'\\'.$delivery.'Deliverer';
    $delivery = class_exists($class) ? $class : $delivery;

    $this->builder->build($delivery)->deliver();
  }
}
