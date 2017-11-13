<?php

namespace Joppli\Acl\Aware;

use
Joppli\Acl\Acl,
Joppli\Acl\AclBuilder,
Joppli\Builder\Injector,
Joppli\Config\Aware\ConfigAware,
Joppli\Config\Aware\ConfigAwareTrait;

class AclInjector implements Injector, ConfigAware
{
  use ConfigAwareTrait;

  protected
  $acl,
  $builder;

  public function __construct(AclBuilder $builder)
  {
    $this->builder = $builder;
  }

  public function inject($instance)
  {
    if($instance instanceof AclAware)
      $instance->setAcl($this->getAcl());
  }

  protected function getAcl() : Acl
  {
    if(!$this->acl)
      $this->acl = $this->builder->build($this->config);

    return $this->acl;
  }
}
