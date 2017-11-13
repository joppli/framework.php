<?php

namespace Joppli\Config;

class ConfigFilter
{
  /**
   * OBS! This action is very expensive, the result SHOULD be cached...
   *
   * @param array $config
   * @param array $filter the function manages following root elements:
   *
   * `Environment`: Environment variables that needs to be replaced to it's
   * true value. Thees will only be filtered in the value of the leaf nodes.
   *
   * @return Config (immutable)
   */
  public function filter(array $config, array $filter) : Config
  {
    $filter = new Config($filter);
    $this->filterEnvironmentVariables($config, $filter->environment->toArray());

    $config = new Config($config);
    return $config;
  }

  protected function filterEnvironmentVariables(array &$config, array $vars)
  {
    array_walk_recursive($config, function(&$value) use($vars)
    {
      if(in_array($value, $vars, true))
        $value = getenv($value);
    });
  }
}
