<?php

namespace Joppli\Application;

use
Joppli\Api\FrontDispatcher,
Joppli\Deliverer\FrontDeliverer;

class Application
{
  protected
  $dispatcher,
  $deliverer;

  public function __construct(
    FrontDispatcher $dispatcher,
    FrontDeliverer  $deliverer)
  {
    $this->dispatcher = $dispatcher;
    $this->deliverer  = $deliverer;
  }

  public function run()
  {
    $this->dispatcher->dispatch();
    $this->deliverer->deliver();
  }
}
