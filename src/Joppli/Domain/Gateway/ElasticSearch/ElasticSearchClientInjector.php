<?php

namespace Joppli\Domain\Gateway\ElasticSearch;

use Joppli\Builder\Injector;

class ElasticSearchClientInjector implements Injector
{
  protected
  $factory,
  $client;

  public function __construct(ElasticSearchClientFactory $factory)
  {
    $this->factory = $factory;
  }

  public function inject($instance)
  {
    if($instance instanceof ElasticSearchClientAware)
      $instance->setClient(
        $this->client ?? $this->client = $this->factory->create());
  }
}
