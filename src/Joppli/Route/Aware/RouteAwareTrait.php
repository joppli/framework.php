<?php

namespace Joppli\Route\Aware;

use Joppli\Route\Route;

trait RouteAwareTrait
{
  /**
   * @var Route
   */
  protected $route;

  public function setRoute(Route $route)
  {
    $this->route = $route;
  }
}