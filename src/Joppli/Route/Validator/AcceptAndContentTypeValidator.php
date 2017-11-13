<?php

namespace Joppli\Route\Validator;

use Joppli\Config\Config;

class AcceptAndContentTypeValidator extends AbstractRequestValidator
{
  public function validate(Config $options)
  {
    $accepts = array_merge(
      explode(',', strtolower($this->request->getHeader('Accept'))),
      explode(',', strtolower($this->request->getHeader('Content-Type')))
    );
    $types  = $options->type instanceof \Traversable
            ? $options->type
            :[$options->type];

    foreach ($types as $type)
      foreach ($accepts as $accept)
        if(strcasecmp($accept, $type) == 0)
          return;

    throw new Exception\ValidatorException(
      'input->type MUST match requested content type');
  }
}
