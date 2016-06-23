<?php

namespace Joppli\Auth\Aware;

use Joppli\Auth\Auth;
use Joppli\Auth\AuthBuilder;
use Joppli\Builder\Injector;
use Joppli\Config\Aware\ConfigAware;
use Joppli\Config\Aware\ConfigAwareTrait;

class AuthInjector implements Injector, ConfigAware
{
  use ConfigAwareTrait;

  protected
    $auth,
    $builder;

  public function __construct(AuthBuilder $builder)
  {
    $this->builder = $builder;
  }

  public function inject($instance)
  {
    if($instance instanceof AuthAware)
      $instance->setAuth($this->getAuth());
  }

  protected function getAuth() : Auth
  {
    if(!$this->auth)
      $this->auth = $this->builder->build($this->config);

    return $this->auth;
  }
}