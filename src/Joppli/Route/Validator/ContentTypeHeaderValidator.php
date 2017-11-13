<?php

namespace Joppli\Route\Validator;

use Joppli\Config\Config;

class ContentTypeHeaderValidator extends AbstractRequestValidator
{
  public function validate(Config $options)
  {
    $cts    = explode(';', $this->request->getHeader('Content-Type'));
    $cts    = array_map('trim', $cts);
    $types  = $options->type instanceof \Traversable
            ? $options->type
            :[$options->type];

    foreach ($types as $type)
      foreach ($cts as $ct)
        if(strcasecmp($ct, $type) == 0)
          return;

    throw new Exception\ValidatorException(
      'input->type MUST match requested content type');
  }
}
