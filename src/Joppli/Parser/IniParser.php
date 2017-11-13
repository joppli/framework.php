<?php

namespace Joppli\Parser;

class IniParser implements Parser
{
  public function parse(string $path) : array
  {
    return parse_ini_file($path, true);
  }
}
