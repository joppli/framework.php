<?php

namespace Joppli\Route\Aware;

use
  Joppli\Builder\Injector,
  Joppli\Route\RouteBuilder;
use Joppli\Route\Route;

class RouteInjector implements Injector
{
  protected
    $route,
    $routeBuilder;

  public function __construct(RouteBuilder $builder)
  {
    $this->routeBuilder = $builder;
  }

  public function inject($instance)
  {
    if($instance instanceof RouteAware)
      $instance->setRoute($this->getRoute());
  }

  protected function getRoute() : Route
  {
    if(!$this->route)
      $this->route = $this->routeBuilder->build();

    return $this->route;
  }
}