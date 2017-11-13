<?php

namespace Joppli\Domain;

class Repository
{
  protected
  $gateway,
  $domain,
  $type;

  public function __construct(Gateway $gateway, string $domain, string $type)
  {
    $this->gateway = $gateway;
    $this->domain  = $domain;
    $this->type    = $type;
  }

  public function create(
    array   $body,
    string  $id = null)
  {
    return $this->gateway->create($this->domain, $this->type, $body, $id);
  }

  public function retrieve(
    string  $id           = null,
    array   $association  = [],
    array   $order        = [],
    int     $from         = 0,
    int     $size         = 1000) : array
  {
    return $this->gateway->retrieve(
      $this->domain, $this->type, $id, $association, $order, $from, $size);
  }

  public function update(
    array   $body,
    string  $id           = null,
    array   $association  = [])
  {
    $this->gateway->update(
      $this->domain, $this->type, $body, $id, $association);
  }

  public function delete(
    string  $id           = null,
    array   $association  = [])
  {
    $this->gateway->delete($this->domain, $this->type, $id, $association);
  }
}
