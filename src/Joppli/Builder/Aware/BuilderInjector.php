<?php

namespace Joppli\Builder\Aware;

use
  Joppli\Builder\Injector,
  Joppli\Builder\Builder;

class BuilderInjector implements Injector
{
  protected $builder;

  public function __construct(Builder $builder)
  {
    $this->builder = $builder;
  }

  public function inject($instance)
  {
    if($instance instanceof BuilderAware)
      $instance->setBuilder($this->builder);
  }
}