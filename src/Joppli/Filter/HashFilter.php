<?php

namespace Joppli\Filter;

class HashFilter
{
  public function filter($input, string $algoritm, string $salt, int $iterate=1)
  {
    if(empty($input))
      return $input;

    $output = $input.$salt;

    for($i = 0; $i < $iterate; $i++)
      $output = hash($algoritm, $output);

    return $output;
  }
}
