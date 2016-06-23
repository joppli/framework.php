<?php

namespace Joppli\Route\Validator;

trait RegexCompareTrait
{
  protected function compare(string $regex, string $str) : bool
  {
    $regex = str_replace( '/', '\\/', $regex);
    $regex = '/^' . $regex . '$/';
    return preg_match($regex, $str);
  }
}