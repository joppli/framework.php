<?php

namespace Joppli\Parser;

class JsonParser implements Parser
{
  public function parse(string $path) : array
  {
    $json = file_get_contents($path);
    return json_decode($json, true);
  }
}
