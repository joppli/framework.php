<?php

namespace Joppli\Filter;

class TrimFilter
{
  public function filter($input)
  {
    return trim($input);
  }
}
