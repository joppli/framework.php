<?php

namespace Joppli\Auth;

use Joppli\Acl\Acl;

class Auth
{
  protected
    $acl,
    $user;

  public function __construct(Acl $acl)
  {
    $this->acl = $acl;
  }

  public function authorize($role, $resource, $operation)
  {
    if(!$this->acl->isGranted($role, $resource, $operation))
      throw new Exception\UnauthorizedException;
  }
}