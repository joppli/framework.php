<?php

namespace Joppli\Route\Validator;

use Joppli\Config\Config;

class AcceptHeaderValidator extends AbstractRequestValidator
{
  public function validate(Config $options)
  {
    if(strcasecmp($this->request->getHeader('Accept'), $options->accept) != 0)
      throw new Exception\ValidatorException(
        'input->accept MUST match requested "accept" header');
  }
}
