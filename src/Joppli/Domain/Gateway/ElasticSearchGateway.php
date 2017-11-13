<?php

namespace Joppli\Domain\Gateway;

use
Joppli\Domain\Gateway,
Elasticsearch\Common\Exceptions\Conflict409Exception;

// @todo: currently we can only delete or update 10000 items at the time...
class ElasticSearchGateway
implements Gateway, ElasticSearch\ElasticSearchClientAware
{
  use ElasticSearch\ElasticSearchClientAwareTrait;

  public function create(
    string  $domain,
    string  $type,
    array   $body,
    string  $id = null)
  {
    $query =
    [
      'refresh' => true,
      'index'   => $domain,
      'type'    => $type,
      'body'    => $body
    ];
    $count =
    [
      'index' => $domain,
      'type'  => $type
    ];

    for($i = 0 ;; $i++)
      try
      {
        $query['id'] = $id ?: $this->client->count($count)['count'] + 1;
        return $this->client->create($query)['_id'];
      }
      // @todo: set a specific exception
      catch(Conflict409Exception $ex)
      {
        if($id || $i == 15)
          throw $ex;
      }
  }

  public function retrieve(
    string  $domain,
    string  $type,
    string  $id           = null,
    array   $association  = [],
    array   $order        = [],
    int     $from         = 0,
    int     $size         = 10000) : array
  {
    $query =
    [
      'index' => $domain,
      'type'  => $type,
      'from'  => $from,
      'size'  => $size
    ];

    if($id)
      $association['_id'] = $id;

    foreach ($association as $property => $value)
      $query['body']['query']['bool']['must'][] =
      [
        'match' =>
        [
          $property =>
          [
            'query'             => $value ?: '',
            'operator'          => 'and',
            'zero_terms_query'  => 'all'
          ]
        ]
      ];

    if(!$query['body']['query'])
      $query['body']['query']['match_all'] = [];

    if($order)
      $query['body']['sort'] = array_map(function($item)
      {
        $parts = explode(':', $item);
        return [$parts[0] => ['order' => $parts[1] ?? 'asc']];
      }, $order);

    $results = [];
    foreach($this->client->search($query)['hits']['hits'] as $result)
      $results[$result['_id']] = $result['_source'];

    return $results;
  }

  public function update(
    string  $domain,
    string  $type,
    array   $body,
    string  $id          = null,
    array   $association = [])
  {
    $params =
    [
      'refresh' => true,
      'index'   => $domain,
      'type'    => $type
    ];

    foreach($this->retrieve($domain, $type, $id, $association) as $id => $item)
    {
      $params['id'] = $id;
      $params['body']['doc'] = $body;

      // all array values are appended/merged instead of replaced
      array_walk($params['body']['doc'], function(&$value, $key)
      {
        if(is_array($value) && isset($item[$key]))
        {
          if(!is_array($item[$key]))
            $item[$key] = [$item[$key]];

          $value = array_merge($item[$key], $value);
        }
      });

      $this->client->update($params);
    }
  }

  public function delete(
    string  $domain,
    string  $type,
    string  $id          = null,
    array   $association = [])
  {
    $params =
    [
      'refresh' => true,
      'index'   => $domain,
      'type'    => $type
    ];

    foreach($this->retrieve($domain, $type, $id, $association) as $id => $_)
    {
      $params['id'] = $id;
      $this->client->delete($params);
    }
  }
}
