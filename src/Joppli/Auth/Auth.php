<?php

namespace Joppli\Auth;

use Joppli\Acl\Acl;

class Auth
{
  protected $acl;

  public function __construct(Acl $acl)
  {
    $this->acl = $acl;
  }

  public function auth(string $role, string $resource, string $operation)
  {
    if(!$this->acl->isGranted($role, $resource, $operation))
      throw new Exception\UnauthorizedException(implode(
      [
        'role: "'     . $role      .'"',
        'resource: "' . $resource  .'"',
        'operation: "'. $operation .'"'
      ], ', '));
  }
}
