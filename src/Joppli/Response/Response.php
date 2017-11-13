<?php

namespace Joppli\Response;

class Response
{
  protected
  $status     = 200,
  $headers    = [],
  $attributes = [];

  public function clearAttributes()
  {
    $this->attributes = [];
  }

  public function getAttributes() : array
  {
    return $this->attributes;
  }

  public function getAttribute(string $key)
  {
    return $this->attributes[$key];
  }

  /**
   * @param string $key
   * @param $value
   */
  public function setAttribute(string $key, $value)
  {
    $this->attributes[$key] = $value;
  }

  /**
   * @see array_replace_recursive
   * @param array $attributes the attributes to set
   */
  public function setAttributes(array $attributes)
  {
    $this->attributes = array_replace_recursive($this->attributes, $attributes);
  }

  public function addHeader(string $header)
  {
    $this->headers[] = $header;
  }

  public function getHeaders() : array
  {
    return $this->headers;
  }

  public function setHeader(string $key, string $header)
  {
    $this->headers[$key] = $header;
  }

  public function getStatus() : int
  {
    return $this->status;
  }

  public function setStatus(int $code)
  {
    $this->status = $code;
  }

  public function __set($key, $value)
  {
    $this->setAttribute($key, $value);
  }
}
