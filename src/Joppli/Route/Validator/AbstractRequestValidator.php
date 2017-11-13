<?php

namespace Joppli\Route\Validator;

use
 Joppli\Request\Aware\RequestAware,
 Joppli\Request\Aware\RequestAwareTrait;

abstract class AbstractRequestValidator
implements RequestAware, RouteValidator
{
  use RequestAwareTrait;
}
