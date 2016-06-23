<?php

namespace Joppli\Route\Validator;

use Joppli\Config\Config;

class RegexPathValidator extends AbstractRequestValidator
{
  use RegexCompareTrait;

  public function validate(Config $options)
  {
    if(!$this->compare($options->path, $this->request->getPath()))
      throw new Exception\ValidatorException(
        'request path MUST match input->path regex');
  }
}