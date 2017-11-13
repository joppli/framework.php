<?php

namespace Joppli\Route\Validator;

use Joppli\Config\Config;

class PathValidator extends AbstractRequestValidator
{
  public function validate(Config $options)
  {
    if(strcmp($this->request->getPath(), $options->path) != 0)
      throw new Exception\ValidatorException(
        'input->path MUST match request path');
  }
}
