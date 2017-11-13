<?php

namespace Joppli\Filter;

use RuntimeException;

class FisherYatesShuffleFilter
{
  public function filter($input, int $seed)
  {
    if(is_string($input))
    {
      $length = strlen($input) - 1;
    }
    elseif(is_array($input))
    {
      $input  = array_values($input);
      $length = count($input) - 1;
    }
    else
    {
      $msg = 'unsupported input type: "'.gettype($input).'"';
      throw new RuntimeException($msg);
    }

    $this->shuffle($length, $input, $seed);
  }

  protected function shuffle(int $i, &$items, int $seed)
  {
    mt_srand($seed);
    for(; $i > 0; $i--)
    {
      $j   = mt_rand(0, $i);
      $tmp = $items[$i];

      $items[$i] = $items[$j];
      $items[$j] = $tmp;
    }
  }
}
