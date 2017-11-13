<?php

namespace Joppli\Domain\Gateway\MySql;

use Joppli\Builder\Injector;

class MySqlPdoInjector implements Injector
{
  protected
  $factory,
  $pdo;

  public function __construct(MySqlPdoFactory $factory)
  {
    $this->factory = $factory;
  }

  public function inject($instance)
  {
    if($instance instanceof MySqlPdoAware)
      $instance->setMySqlPdo(
        $this->pdo ?? $this->pdo = $this->factory->create());
  }
}
