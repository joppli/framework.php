<?php

namespace Joppli\Deliverer;

use
Joppli\Config\Aware\ConfigAware,
Joppli\Config\Aware\ConfigAwareTrait,
Joppli\Route\Aware\RouteAware,
Joppli\Route\Aware\RouteAwareTrait;

class TemplateDeliverer extends AbstractDeliverer
implements ConfigAware, RouteAware
{
  use
  ConfigAwareTrait,
  RouteAwareTrait;

  protected function composeOutput(array $entity) : string
  {
    $name = implode('.', $this->route->getPath());
    $file = $this->config->template->{$name} ?: $this->config->template->{'*'};

    // Using an anonymous class to avoid access to the deliverer class scope
    return (new class($file)
    {
      private $file;

      public function __construct(string $file)
      {
        $this->file = $file;
      }

      public function compose($entity) : string
      {
        if(isset($entity['entity']))
        {
          extract($entity);
        }
        else
        {
          extract($entity);
          unset($entity);
        }

        ob_start();
        require 'template/'.$this->file.'.phtml';
        return ob_get_clean();
      }
    })->compose($entity);
  }
}
