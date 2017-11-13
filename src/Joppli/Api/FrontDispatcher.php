<?php

namespace Joppli\Api;

use
Joppli\Builder\Aware\BuilderAware,
Joppli\Builder\Aware\BuilderAwareTrait,
Joppli\Response\Aware\ResponseAware,
Joppli\Response\Aware\ResponseAwareTrait,
Joppli\Route\Aware\RouteAware,
Joppli\Route\Aware\RouteAwareTrait;

class FrontDispatcher
implements Dispatcher, RouteAware, BuilderAware, ResponseAware
{
  use
  ResponseAwareTrait,
  RouteAwareTrait,
  BuilderAwareTrait;

  public function dispatch()
  {
    try
    {
      foreach ($this->route->getDispatchers() as $dispatcher)
        $this->builder->build($dispatcher)->dispatch();
    }
    catch(Exception\HttpException $httpException)
    {
      $e = $this->composeException($httpException);

      $this->response->clearAttributes();
      $this->response->setAttribute('exception', $e);
      $this->response->setStatus($httpException->getCode());
    }
    catch(\Exception $exception)
    {
      $e = $this->composeException($exception);

      $this->response->clearAttributes();
      $this->response->setAttribute('exception', $e);
      $this->response->setStatus(500);
    }
  }

  protected function composeException($exception)
  {
    $e =
    [
      'type'    => get_class($exception),
      'message' => $exception->getMessage(),
      'code'    => $exception->getCode(),
      'file'    => $exception->getFile(),
      'line'    => $exception->getLine(),
      'trace'   => $exception->getTrace()
    ];

    if($exception->getPrevious())
      $e['previous'] = $this->composeException($exception->getPrevious());

    return $e;
  }
}
