<?php

namespace Joppli\Domain\Gateway\ElasticSearch;

use
Elasticsearch\ClientBuilder,
Joppli\Config\Aware\ConfigAware,
Joppli\Config\Aware\ConfigAwareTrait;

class ElasticSearchClientFactory implements ConfigAware
{
  use ConfigAwareTrait;

  public function __construct(ClientBuilder $builder)
  {
    $this->builder = $builder;
  }

  public function create()
  {
    $hosts = [];
    foreach ($this->config->elastic->hosts as $host)
      $hosts[] = $host->ip.':'.$host->port;

    return $this->builder->setHosts($hosts)->build();
  }
}
