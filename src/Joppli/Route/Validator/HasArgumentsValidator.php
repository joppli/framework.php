<?php

namespace Joppli\Route\Validator;

use Joppli\Config\Config;

class HasArgumentsValidator extends AbstractRequestValidator
{
  public function validate(Config $options)
  {
    foreach($options->arguments as $argument)
      if(!array_key_exists($argument, $this->request->getArguments()))
        throw new Exception\ValidatorException(
          'argument: "' . $argument . '" MUST be present in request body');
  }
}