<?php

namespace Joppli\Config\Aware;

use Joppli\Config\Config;

trait ConfigAwareTrait
{
  /**
   * @var Config
   */
  protected $config;

  public function setConfig(Config $config)
  {
    $this->config = $config;
  }
}