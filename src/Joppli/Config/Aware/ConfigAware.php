<?php

namespace Joppli\Config\Aware;

use Joppli\Config\Config;

interface ConfigAware
{
  public function setConfig(Config $config);
}
