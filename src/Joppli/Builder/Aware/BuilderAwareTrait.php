<?php

namespace Joppli\Builder\Aware;

use Joppli\Builder\Builder;

trait BuilderAwareTrait
{
  /**
   * @var Builder
   */
  protected $builder;

  public function setBuilder(Builder $builder)
  {
    $this->builder = $builder;
  }
}