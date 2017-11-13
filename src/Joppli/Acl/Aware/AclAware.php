<?php

namespace Joppli\Acl\Aware;

use Joppli\Acl\Acl;

interface AclAware
{
  public function setAcl(Acl $acl);
}
