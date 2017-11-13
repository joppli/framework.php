<?php

namespace Joppli\Config;

class ConfigFactory
{
  public function create(array $parser, array $directories) : Config
  {
    foreach($directories as $directory)
    {
      $directory = rtrim($directory, '/');
      foreach(scandir($directory) as $file)
      {
        $suffix = array_pop(explode('.', $file));
        if($parser[$suffix])
        {
          $path = $directory . '/' . $file;
          $config[] = $parser[$suffix]->parse($path);
        }
      }
    }

    return $config ? new Config(array_merge_recursive(...$config)) : new Config;
  }
}
