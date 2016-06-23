<?php

namespace Joppli\Deliverer;

class ScriptDeliverer extends AbstractDeliverer
{
  protected function composeOutput(array $entity) : string
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

    require 'view/'.$file;
    return ob_get_clean();
  }
}