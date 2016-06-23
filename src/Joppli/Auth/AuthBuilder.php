<?php

namespace Joppli\Auth;

use
  Joppli\Acl\Acl,
  Joppli\Config\Config;

class AuthBuilder
{
  public function build(Config $config) : Auth
  {
    $acl = new Acl;

    foreach (['grant', 'deny'] as $section)
      foreach ($config->auth->acl->$section ?: [] as $resource => $operations)
        foreach ($operations as $operation => $roles)
          foreach ($roles as $role)
            $acl->$section($role, $resource, $operation);

    $auth = new Auth($acl);
    return $auth;
  }
}