<?php

namespace Joppli\Validator;

class MultiDimensionalArrayValidator
{
  public function validate($input, string $key = '')
  {
    $multiDimensional = true;

    if(is_array($input))
    {
      foreach($input as $item)
        if(!is_array($item))
        {
          $multiDimensional = false;
          break;
        }
    }
    else
    {
      $multiDimensional = false;
    }

    if(!$multiDimensional)
      throw new Exception\ValidatorException(
        ($key ? $key : 'input') . ' MUST be a complete multi dimensional array');
  }
}
