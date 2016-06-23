<?php

namespace Joppli\Dispatcher;

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
      if(empty($this->route->getResource()))
        throw new Exception\NotFoundException(
          'no resource specified');

      if(empty($this->route->getOperations()))
        throw new Exception\NotFoundException(
          'no operation specified');

      foreach ($this->route->getDispatchers() as $dispatcher)
        $this->builder->build($dispatcher)->dispatch();
    }
    catch(Exception\HttpException $httpException)
    {
      $this->exceptionResponse($httpException);
      $this->response->setStatus($httpException->getCode());
    }
    catch(\Exception $exception)
    {
      $this->exceptionResponse($exception);
      $this->response->setStatus(500);
    }
  }

  protected function exceptionResponse(\Exception $exception)
  {
    $this->response->clearAttributes();
    $this->response->setAttribute('exception',
    [
      'type'    => get_class($exception),
      'message' => $exception->getMessage(),
      'code'    => $exception->getCode(),
      'file'    => $exception->getFile(),
      'line'    => $exception->getLine(),
      'trace'   => $exception->getTrace()
    ]);
  }
}