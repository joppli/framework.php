<?php

namespace Joppli\Domain\Gateway;

use
PDO,
Joppli\Domain\Gateway;

class MySqlGateway implements Gateway, MySql\MySqlPdoAware
{
  use MySql\MySqlPdoAwareTrait;

  public function create(
    string  $domain,
    string  $type,
    array   $body,
    string  $id = null)
  {
    $context = [':domain' => $domain, ':type' => $type];
    array_push($context, ...$this->prepare($body, $keys, $names, $id));
    $sql = 'INSERT INTO `:domain`.`:type` SET ';
    $sql.= $this->compose($keys, $names, ' = ', ', ');
    $stt = $this->mysql->prepare($sql);
    $stt->execute($context);

    // @todo: return id
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
    $context  = [':domain' => $domain, ':type' => $type];
    $sql      = 'SELECT * FROM `:domain`.`:type`';

    if(!empty($association))
    {
      array_push($context, ...$this->prepare($association, $keys, $names, $id));
      $sql .= ' WHERE ';
      $sql .= $this->compose($keys, $names, ' = ', ' AND ');
    }

    if(!empty($order))
    {
      array_push($context, ...$this->prepare($order, $keys, $names));
      $sql .= ' ORDER BY ';
      $sql .= $this->compose($keys, $names, ' ', ', ');
    }

    $sql.= " LIMIT $from, $size";
    $stt = $this->mysql->prepare($sql);
    $stt->execute($context);

    return $stt->fetchAll();
  }

  public function update(
    string  $domain,
    string  $type,
    array   $body,
    string  $id          = null,
    array   $association = [])
  {
    $context  = [':domain' => $domain, ':type' => $type];
    array_push($context, ...$this->prepare($body, $keys, $names));
    $sql = 'UPDATE `:domain`.`:type` SET ';
    $sql.= $this->compose($keys, $names, ' = ', ', ');

    if(!empty($association))
    {
      array_push($context, ...$this->prepare($association, $keys, $names, $id));
      $sql .= ' WHERE ';
      $sql .= $this->compose($keys, $names, ' = ', ' AND ');
    }

    $stt = $this->mysql->prepare($sql);
    $stt->execute($context);
  }

  public function delete(
    string  $domain,
    string  $type,
    string  $id          = null,
    array   $association = [])
  {
    $context  = [':domain' => $domain, ':type' => $type];
    $sql      = 'DELETE FROM `:domain`.`:type`';

    if(!empty($association))
    {
      array_push($context, ...$this->prepare($association, $keys, $names, $id));
      $sql .= ' WHERE ';
      $sql .= $this->compose($keys, $names, ' = ', ' AND ');
    }

    $stt = $this->mysql->prepare($sql);
    $stt->execute($context);
  }

  /**
   * Composes the query part
   */
  protected function compose(
    array   $keys,
    array   $names,
    string  $binding,
    string  $glue) : string
  {
    $composed = array_map(function($key, $name)
    {
      return "`$key`{$binding}{$name}";
    }, $keys, $names);
    return implode($glue, $composed);
  }

  /**
   * Assumes that the primary key is named `id`
   */
  protected function prepare(
    array $association,
    &$keys      = [],
    &$names     = [],
    string $id  = null) : array
  {
    $context = [];
    $filter  = function($key, $value) use($context, $keys, $names)
    {
      array_push($keys, $key);
      $name = ":_$key";
      array_push($names, $name);
      $context[$name] = $value;
    };

    // removes the id attribute, if one is passing it as part of the body, then
    // it wont work for other gateway types.
    // @todo: ...makes it impossible to order by id
    unset($association['id']);

    if(!is_null($id))
      $filter('id', $id);

    foreach ($association as $key => $value)
      $filter($key, $value);

    return $context;
  }
}
