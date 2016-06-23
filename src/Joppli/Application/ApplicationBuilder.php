<?php

namespace Joppli\Application;

use
  Joppli\Config\Aware\ConfigInjector,
  Joppli\Request\Aware\RequestInjector,
  Joppli\Builder\Aware\BuilderInjector,
  Joppli\Config\Config,
  Joppli\Builder\Builder,
  Joppli\Request\Request;

class ApplicationBuilder
{
  public function build(Config $config, Request $request)
  {
    $builder = new Builder;
    $this->addDefaultInjectors($builder, $config, $request);
    $this->addApplicationInjectors($builder, $config);

    return $builder->build(__NAMESPACE__.'\\Application');
  }

  protected function addDefaultInjectors(
    Builder $builder,
    Config  $config,
    Request $request)
  {
    $builder->addInjector(new BuilderInjector($builder));
    $builder->addInjector(new ConfigInjector($config));
    $builder->addInjector(new RequestInjector($request));
  }

  protected function addApplicationInjectors(Builder $builder, Config $config)
  {
    foreach ($config->aware->injectors as $className)
    {
      $injector = $builder->build($className);
      $builder->addInjector($injector);
    }
  }
}