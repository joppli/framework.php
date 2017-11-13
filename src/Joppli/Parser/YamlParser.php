<?php

namespace Joppli\Parser;

class YamlParser implements Parser
{
  public function parse(string $path) : array
  {
    $yaml = yaml_parse_file($path);
    if($yaml)
      return $yaml;

    throw new Exception\ParserException('can not parse: "'.$path.'"');
  }
}
