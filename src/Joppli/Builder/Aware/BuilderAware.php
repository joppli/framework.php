<?php

namespace Joppli\Builder\Aware;

use Joppli\Builder\Builder;

interface BuilderAware
{
  public function setBuilder(Builder $builder);
}