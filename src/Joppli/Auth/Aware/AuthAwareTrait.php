<?php

namespace Joppli\Auth\Aware;

use Joppli\Auth\Auth;

trait AuthAwareTrait
{
  /**
   * @var Auth
   */
  protected $auth;

  public function setAuth(Auth $auth)
  {
    $this->auth = $auth;
  }
}