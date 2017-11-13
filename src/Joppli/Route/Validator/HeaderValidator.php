<?php

namespace Joppli\Route\Validator;

use Joppli\Config\Config;

class HeaderValidator extends AbstractRequestValidator
{
  public function validate(Config $options)
  {
    if(!isset($options->header) || !isset($options->value))
      throw new Exception\ValidatorException(
        'input->header and input->value MUST be set');

    if(!$this->request->getHeader($options->header))
      throw new Exception\ValidatorException(
        $options->header.' header MUST be set');

    if(is_array($options->value))
      if(in_array($options->value, $this->request->getHeader($options->header)))
        throw new Exception\ValidatorException(
          $options->header.' header MUST be one of: '.implode(', ', $options->value));

    else
      if($this->request->getHeader($options->header) != $options->value)
        throw new Exception\ValidatorException(
          $options->header.' header MUST be equal to '.$options->value);
  }
}
