<?php

namespace Joppli\Transformer;

class StringToBoolTransformer
{
  public function transform(string $input = null) : bool
  {
    $filter   = FILTER_VALIDATE_BOOLEAN;
    $options  = FILTER_NULL_ON_FAILURE;
    $bool     = filter_var($input, $filter, $options);

    return $bool;
  }
}