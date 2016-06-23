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

  public function getArg(string $key) : string
  {
    return (string) $this->arguments[$key];
  }

  public function getArguments() : array
  {
    return $this->arguments;
  }

  public function __get($key)
  {
    return $this->getArg($key);
  }

  public function getHeader(string $name) : string
  {
    $nameFiltered = str_replace('-', '_', $name);
    $header       = strtoupper($nameFiltered);

    return $this->server[$header]
        ?? $this->server[$this->getProtocol().'_'.$header]
        ?? '';
  }

  public function getHost() : string
  {
    return $this->server['HTTP_HOST'];
  }

  public function getMethod() : string
  {
    return $this->server['REQUEST_METHOD'];
  }

  public function getPath() : string
  {
    if(!$this->path)
      $this->path = strtok($this->getUri(), '?');

    return $this->path;
  }

  public function getProtocol() : string
  {
    if(!$this->protocol)
    {
      $protocol = $this->server['SERVER_PROTOCOL'];
      $protocol = substr($protocol, 0, strpos($protocol, '/'));

      $this->protocol = $protocol;
    }

    return $this->protocol;
  }

  public function getSegment($index) : string
  {
    $segments = $this->getSegments();
    return $segments[$index];
  }

  public function getSegments() : array
  {
    if(!$this->segments)
      $this->segments = explode('/', $this->getPath());

    return $this->segments;
  }

  public function getUri() : string
  {
    return $this->server['REQUEST_URI'];
  }

  public function hasArg(string $key) : bool
  {
    return isset($this->arguments[$key]);
  }

  public function isMethod(string $method) : bool
  {
    return strcasecmp($this->getMethod(), $method) === 0;
  }
}