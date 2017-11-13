<?php

namespace Joppli\Domain\Repository;

use Joppli\Builder\Injector;

class RepositoryInjector implements Injector
{
  protected $locator;

  public function __construct(RepositoryLocator $locator)
  {
    $this->locator = $locator;
  }

  public function inject($instance)
  {
    if($instance instanceof RepositoryAware)
      $instance->setRepository($this->locator);
  }
}
