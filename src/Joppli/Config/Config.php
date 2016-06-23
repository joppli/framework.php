<?php

namespace Joppli\Config;

use
  ArrayAccess,
  Iterator,
  JsonSerializable,
  stdClass;

class Config extends stdClass implements ArrayAccess, Iterator, JsonSerializable
{
  protected
    $immutable,
    $data;

  public function __construct(array $structure = [], $immutable = false)
  {
    $this->data = $this->filter($structure);
    $this->immutable = $immutable;
  }

  public function toArray() : array
  {
    return $this->data;
  }

  public function __set($name, $value)
  {
    if($this->immutable)
      throw new Exception\ImmutableException;

    $key = strtolower($name);
    $this->data[$key] = $value;
  }

  public function __unset($name)
  {
    if($this->immutable)
      throw new Exception\ImmutableException;

    $key = strtolower($name);
    unset($this->data[$key]);
  }

  public function __get($name)
  {
    $key = strtolower($name);

    if(isset($this->data[$key]))
      return is_array($this->data[$key])
        ? new class($this->data[$key], $this->immutable) extends Config
        {
          public function __construct(array $structure, $immutable)
          {
            $this->data = $structure;
            $this->immutable = $immutable;
          }
        }
        : $this->data[$key];

    return null;
  }

  public function __isset($name)
  {
    $key = strtolower($name);
    return isset($this->data[$key]);
  }

  /**
   * Converts all keys to lower case, recursive..
   *
   * @param array $structure
   * @return array
   */
  protected function filter(array $structure) : array
  {
    return array_map(function($structure)
    {
      if(is_array($structure))
        $structure = $this->filter($structure);

      return $structure;
    },
    array_change_key_case($structure));
  }

  // Array access interface

  public function offsetSet($offset, $value)
  {
    if(is_null($offset))
      $this->data[] = $value;

    else
      $this->__set($offset, $value);
  }

  public function offsetExists($offset)
  {
    return $this->__isset($offset);
  }

  public function offsetUnset($offset)
  {
    $this->__unset($offset);
  }

  public function offsetGet($offset)
  {
    return $this->__get($offset);
  }

  // Iterator interface

  public function rewind()
  {
    reset($this->data);
  }

  public function current()
  {
    $key = $this->key();
    return $this->__get($key);
  }

  public function key()
  {
    return key($this->data);
  }

  public function next()
  {
    next($this->data);
  }

  public function valid()
  {
    return key($this->data) !== null;
  }

  // JsonSerializable interface

  public function jsonSerialize()
  {
    return $this->data;
  }
}