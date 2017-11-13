<?php

namespace Joppli\Domain\Gateway\ElasticSearch;

use Elasticsearch\Client;

interface ElasticSearchClientAware
{
  public function setClient(Client $client);
}
