<?php

namespace Joppli\Acl\Aware;

use Joppli\Acl\Acl;

trait AclAwareTrait
{
  /**
   * @var Acl
   */
  protected $acl;

  public function setAcl(Acl $acl)
  {
    $this->acl = $acl;
  }
}
