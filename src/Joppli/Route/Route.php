<?php

namespace Joppli\Route;

class Route
{
  protected
  $path,
  $deliverer,
  $dispatchers = [];

  public function __construct(
    array   $path,
    string  $deliverer,
    array   $dispatchers)
  {
    $this->path         = $path;
    $this->deliverer    = $deliverer;
    $this->dispatchers  = $dispatchers;
  }

  public function getPath() : array
  {
    return $this->path;
  }

  public function getDeliverer() : string
  {
    return $this->deliverer;
  }

  public function getDispatchers() : array
  {
    return $this->dispatchers;
  }
}
