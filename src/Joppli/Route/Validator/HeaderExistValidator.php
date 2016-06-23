<?php

namespace Joppli\Route\Validator;

use Joppli\Config\Config;

class HeaderExistValidator extends AbstractRequestValidator
{
  public function validate(Config $options)
  {
    if(!$options->header || !$this->request->getHeader($options->header))
      throw new Exception\ValidatorException(
        'input->header MUST be set');
  }
}