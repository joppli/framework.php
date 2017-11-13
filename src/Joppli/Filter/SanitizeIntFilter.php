<?php

namespace Joppli\Filter;

class SanitizeIntFilter
{
  public function filter($input)
  {
    return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
  }
}
