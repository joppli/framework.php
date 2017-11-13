<?php

namespace Joppli\Acl;

use Joppli\Config\Config;

class AclBuilder
{
  public function build(Config $config) : Acl
  {
    $acl = new Acl;

    foreach (['grant', 'deny'] as $section)
      foreach ($config->acl->$section ?? [] as $resource => $operations)
        foreach ($operations as $operation => $roles)
          foreach (is_string($roles) ? [$roles] : $roles->toArray() as $role)
            $acl->$section($role, $resource, $operation);

    return $acl;
  }
}
