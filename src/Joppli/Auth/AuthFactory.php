<?php

namespace Joppli\Auth;

use Joppli\Acl\Acl;

class AuthFactory
{
  public function create(Acl $acl) : Auth
  {
    $auth = new Auth($acl);
    return $auth;
  }
}
