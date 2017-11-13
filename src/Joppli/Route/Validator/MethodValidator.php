<?php

namespace Joppli\Route\Validator;

use Joppli\Config\Config;

class MethodValidator extends AbstractRequestValidator
{
  public function validate(Config $options)
  {
    if(strcasecmp($this->request->getMethod(), $options->method) != 0)
      throw new Exception\ValidatorException(
        'input->method MUST match request method');
  }
}
