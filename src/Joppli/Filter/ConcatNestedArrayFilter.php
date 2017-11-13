<?php

namespace Joppli\Filter;

class ConcatNestedArrayFilter
{
  public function filter($input)
  {
    $this->composer($input, $output);
    return $output ? trim($output) : '';
  }

  protected function composer($input, &$output)
  {
    if(is_array($input) || $input instanceof \Traversable)
      foreach($input as $attr => $value)
      {
        $output .= is_string($attr)
                 ? PHP_EOL . $attr . ': '
                 : PHP_EOL;

        $this->composer($value, $output);
      }
    else
      $output .= $input;
  }
}
