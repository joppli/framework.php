<?php

namespace Joppli\Route\Validator;

use Joppli\Config\Config;

class AcceptHeaderValidator extends AbstractRequestValidator
{
  public function validate(Config $options)
  {
    $accepts  = [];
    foreach (explode(';', $this->request->getHeader('Accept')) as $accept)
      array_push($accepts, ...explode(',', $accept));

    $accepts  = array_map('trim', $accepts);
    $types    = $options->type instanceof \Traversable
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
