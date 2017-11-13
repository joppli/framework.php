<?php

namespace Joppli\Route\Aware;

use Joppli\Route\Route;

interface RouteAware
{
  public function setRoute(Route $route);
}
