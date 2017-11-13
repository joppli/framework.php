<?php

namespace Joppli\Filter;

class LowerCaseFilter
{
  public function filter($input)
  {
    return strtolower($input);
  }
}
