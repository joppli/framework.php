<?php

namespace Joppli\Auth\Aware;

use
Joppli\Acl\Aware\AclAware,
Joppli\Acl\Aware\AclAwareTrait,
Joppli\Auth\Auth,
Joppli\Auth\AuthFactory,
Joppli\Builder\Injector;

class AuthInjector implements Injector, AclAware
{
  use AclAwareTrait;

  protected
  $auth,
  $factory;

  public function __construct(AuthFactory $factory)
  {
    $this->factory = $factory;
  }

  public function inject($instance)
  {
    if($instance instanceof AuthAware)
      $instance->setAuth($this->getAuth());
  }

  protected function getAuth() : Auth
  {
    if(!$this->auth)
      $this->auth = $this->factory->create($this->acl);

    return $this->auth;
  }
}
