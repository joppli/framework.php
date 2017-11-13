<?php

namespace Joppli\Domain\Repository;

use
Joppli\Config\Aware\ConfigAware,
Joppli\Config\Aware\ConfigAwareTrait,
Joppli\Domain\Repository,
Joppli\Locator\Locator;

class RepositoryLocator extends Locator implements ConfigAware
{
  use ConfigAwareTrait;

  public function get(string $name) : Repository
  {
    if(!isset($this->container[$name]))
    {
      $config     = $this->config->repository->$name;
      $gateway    = $this->builder->build($config->gateway);
      $repository = new Repository($gateway, $config->domain, $config->type);

      $this->container[$name] = $repository;
    }

    return $this->container[$name];
  }
}
