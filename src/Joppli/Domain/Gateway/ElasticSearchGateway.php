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

  public function scroll(string $id, string $time, string &$newId) : array
  {
    $query =
    [
      'scroll_id' => $id,
      'scroll'    => $time
    ];
    $gatewayResults = $this->client->scroll($query);
    $results = array();
    foreach($gatewayResults['hits']['hits'] as $result) {
      $result['_source']['id'] = $result['_id'];
      $results[] = $result['_source'];
    }
    $newId = $gatewayResults['_scroll_id'];
    return $results;
  }

  public function retrieve(
    string  $domain,
    string  $type,
    string  $id           = null,
    array   $association  = [],
    array   $order        = [],
    int     $from         = 0,
    int     $size         = 10000,
    int    &$count        = 0,
    string &$scroll       = null) : array
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

    if(array_key_exists('id', $association)){
      $association['_id'] = $association['id'];
      unset($association['id']);
    }

    if(array_key_exists('_should', $association)){
      $should = $association['_should'];
      unset($association['_should']);
    } else {
      $should = [];
    }
    if(array_key_exists('_filter', $association)) {
      $filter = $association['_filter'];
      unset($association['_filter']);
    } else {
      $filter = false;
    }

    if(array_key_exists('_terms', $association)){
      $terms = $association['_terms'];
      unset ($association['_terms']);
    } else {
      $terms = false;
    }

    if($scroll){
      $query['scroll'] = $scroll;
    }

    foreach ($association as $property => $value){
      $query['body']['query']['bool']['must'][] =
        !is_array($value) || $value['mode'] == 'MATCH'
        ? [
          'match' =>
          [
            $property =>
            [
              'query'             => (!is_array($value) ? $value : $value['value']) ?: '',
              'operator'          => 'and',
              'zero_terms_query'  => 'all'
            ]
          ]
        ]
        : [
          'match_phrase_prefix' =>
          [
            $property => [
              'query' => $value['value']
              //,analyzer => 'whatever'
            ]
          ]
        ];
    }

    foreach($should as $property => $value) {
      $query['body']['query']['bool']['should'][] = ['terms' => [ $property => $value ]];
    }

    if($filter)
    {
      $query['body']['query']['bool']['filter'] = $filter;
    }

    if($terms) {
      $query['body']['query']['terms'] = $terms;
    }

    if($order && count($order))
      $query['body']['sort'] = array_map(
        function($key, $value){
          return array($key == 'id' ? '_uid' : $key => $value == 'desc' ? $value : 'asc');
        },
        array_keys($order), $order);

      /*= array_map(function($item)
      {
        $parts = explode(':', $item);
        return [$parts[0] == 'id' ? '_uid' : $parts[0]  => ['order' => $parts[1] ?? 'asc']];
      }, $order);*/

    $results = [];
    $gatewayResults = $this->client->search($query);
    foreach($gatewayResults['hits']['hits'] as $result) {
      $result['_source']['id'] = $result['_id'];
      $results[] = $result['_source'];
    }
    $count = $gatewayResults['hits']['total'];
    if($scroll){
      $scroll = $gatewayResults['_scroll_id'];
    }
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
    foreach($this->retrieve($domain, $type, $id, $association) as $item)
    {
      $params['id'] = $item['id'];
      unset($item['id']);
      $params['body']['doc'] = $item;
      //Existing item replaced values
      foreach ($body as $key => $value) {
        $params['body']['doc'][$key] = $value;
      }
      // all array values are appended/merged instead of replaced
      /*array_walk($params['body']['doc'], function(&$value, $key)
      {
        if(is_array($value) && isset($item[$key]))
        {
          if(!is_array($item[$key]))
            $item[$key] = [$item[$key]];

          $value = array_merge($item[$key], $value);
        }
      });*/
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

    foreach($this->retrieve($domain, $type, $id, $association) as $item)
    {
      $params['id'] = $item['id'];
      $this->client->delete($params);
    }
  }
}
