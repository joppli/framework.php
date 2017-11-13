<?php

namespace Joppli\Locator;

use
Joppli\Builder\Aware\BuilderAware,
Joppli\Builder\Aware\BuilderAwareTrait;

/**
 * Class Locator
 *
 * Please don't use a global service locator.. don't be a retard.. it serves
 * it's purpose in isolated situation, but a global scope should always be
 * avoided..
 *
 * @package Joppli\Locator
 */
class Locator implements BuilderAware
{
  use BuilderAwareTrait;

  protected $container = [];

  /**
   * Lazy loads an instance
   *
   * @param string $service
   * @return mixed
   */
  public function get(string $service)
  {
    if(!isset($this->container[$service]))
      $this->container[$service] = $this->builder->build($service);

    return $this->container[$service];
  }

  public function __get($name)
  {
    return $this->get($name);
  }
}
