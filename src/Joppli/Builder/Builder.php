<?php

namespace Joppli\Builder;

use
ReflectionClass,
ReflectionMethod,
ReflectionException;

class Builder
{
  protected $injectors = [];

  public function addInjector(Injector $injector)
  {
    $this->injectors[] = $injector;
  }

  /**
   * Creates an instance of the class specified as an argument. Uses the
   * ReflectionClass to construct the instance..
   *
   * @param string $className
   * @return mixed
   * @throws Exception\BuilderException
   */
  public function build(string $className)
  {
    try
    {
      return $this->create($className);
    }
    catch(ReflectionException $e)
    {
      $msg = 'could not build: ' . $className;
      throw new Exception\BuilderException($msg, null, $e);
    }
  }

  protected function create(string $className)
  {
    $reflection  = new ReflectionClass($className);
    $arguments   = $this->getArguments($reflection->getConstructor());
    $instance    = $reflection->newInstanceArgs($arguments);

    $this->injectAwareDependency($instance);

    return $instance;
  }

  protected function injectAwareDependency($instance)
  {
    foreach ($this->injectors as $injector)
      $injector->inject($instance);
  }

  /**
   * Used internally to receive the arguments necessary to construct the
   * instance
   *
   * @param ReflectionMethod $method
   * @return array
   * @throws ReflectionException
   */
  protected function getArguments(ReflectionMethod $method = null) : array
  {
    $arguments = [];

    if($method)
      foreach ($method->getParameters() as $param)
        if(!$param->isOptional())
          try
          {
            $className = $param->getClass()->name;
            if(!is_null($className))
              $arguments[] = $this->create($className);
          }
          catch (ReflectionException $e)
          {
            $msg = 'Error occurred when attempting to build: '.$method->class;
            throw new ReflectionException($msg, null, $e);
          }

    return $arguments;
  }
}
