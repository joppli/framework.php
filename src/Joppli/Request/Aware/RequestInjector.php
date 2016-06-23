<?php

namespace Joppli\Request\Aware;

use
  Joppli\Builder\Injector,
  Joppli\Request\Request;

class RequestInjector implements Injector
{
  protected $request;

  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function inject($instance)
  {
    if($instance instanceof RequestAware)
      $instance->setRequest($this->request);
  }
}