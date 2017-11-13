<?php

namespace Joppli\Domain\Gateway\ElasticSearch;

use Elasticsearch\Client;

trait ElasticSearchClientAwareTrait
{
  /**
   * @var Client
   */
  protected $client;

  public function setClient(Client $client)
  {
    $this->client = $client;
  }
}
