<?php

namespace Joppli\Config\Aware;

use
Joppli\Builder\Injector,
Joppli\Config\Config;

class ConfigInjector implements Injector
{
  /**
   * @var Config
   */
  protected $config;

  public function __construct(Config $config)
  {
    $this->config = $config;
  }

  public function inject($instance)
  {
    if($instance instanceof ConfigAware)
      $instance->setConfig($this->config);
  }
}
