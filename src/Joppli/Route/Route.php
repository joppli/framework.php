<?php

namespace Joppli\Route;

class Route
{
  protected
    $resource,
    $operations,
    $deliverer,
    $dispatchers = [];

  public function __construct(
    string  $resource,
    array   $operations,
    string  $deliverer,
    array   $dispatchers)
  {
    $this->resource     = $resource;
    $this->operations   = $operations;
    $this->deliverer    = $deliverer;
    $this->dispatchers  = $dispatchers;
  }

  public function getResource() : string
  {
    return $this->resource;
  }

  public function getOperations() : array
  {
    return $this->operations;
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