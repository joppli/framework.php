<?php

namespace Joppli\Route\Validator;

use Joppli\Config\Config;

class SegmentCountValidator extends AbstractRequestValidator
{
  public function validate(Config $options)
  {
    $count = count($this->request->getSegments());
    if($count != $options->count)
      throw new Exception\ValidatorException(
        'segment count MUST be: ' . $options->count . ', ' . $count . ' given');
  }
}