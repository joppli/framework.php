<?php

namespace Joppli\Route\Validator;

use Joppli\Config\Config;

interface RouteValidator
{
  public function validate(Config $options);
}
