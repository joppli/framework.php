<?php

namespace Joppli\Auth\Aware;

use Joppli\Auth\Auth;

interface AuthAware
{
  public function setAuth(Auth $auth);
}