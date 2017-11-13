<?php

namespace Joppli\Request;

class Request
{
  private
  $protocol,
  $arguments,
  $segments,
  $path,
  $server;

  public function __construct(array $arguments, array $server)
  {
    $this->arguments  = $arguments;
    $this->server     = $server;
  }

  public function getArg(string $key)
  {
    return $this->arguments[$key];
  }

  public function __get($key)
  {
    return $this->getArg($key);
  }

  public function getHost()
  {
    return $this->server['HTTP_HOST'];
  }

  public function getHeader(string $name)
  {
    $nameFiltered = str_replace('-', '_', $name);
    $header       = strtoupper($nameFiltered);
    $key          = $this->getProtocol() . '_' . $header;

    return $this->server[$header] ?? $this->server[$key];
  }

  public function getMethod()
  {
    return strtolower($this->server['REQUEST_METHOD']);
  }

  public function getPath()
  {
    if(!$this->path)
      $this->path = strtok($this->getUri(), '?');

    return $this->path;
  }

  public function getProtocol()
  {
    if(!$this->protocol)
    {
      $protocol = $this->server['SERVER_PROTOCOL'];
      $protocol = substr($protocol, 0, strpos($protocol, '/'));

      $this->protocol = $protocol;
    }

    return $this->protocol;
  }

  public function getSegment($index)
  {
    $segments = $this->getSegments();
    return $segments[$index];
  }

  public function getSegments()
  {
    if(!$this->segments)
      $this->segments = explode('/', $this->getPath());

    return $this->segments;
  }

  public function getUri()
  {
    return $this->server['REQUEST_URI'];
  }

  public function hasArg(string $key)
  {
    return isset($this->arguments[$key]);
  }

  public function isMethod(string $method)
  {
    return strcasecmp($this->getMethod(), $method) == 0;
  }
}
