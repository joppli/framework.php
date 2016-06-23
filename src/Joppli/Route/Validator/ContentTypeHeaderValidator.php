<?php

namespace Joppli\Route\Validator;

use Joppli\Config\Config;

class ContentTypeHeaderValidator extends AbstractRequestValidator
{
  public function validate(Config $options)
  {
    $contentType = $this->request->getHeader('Content-Type');
    if(strcasecmp($contentType, $options->type) != 0)
      throw new Exception\ValidatorException(
        'input->type MUST match requested content type');
  }
}