<?php

namespace Joppli\Request;

class RequestFactory
{
  protected $request;

  public function create()
  {
    $rawInput   = file_get_contents('php://input');
    $arguments  = $this->composeArgs($rawInput, $_REQUEST);
    $request    = new Request($arguments, $_SERVER);

    return $request;
  }

  protected function composeArgs($rawInput, $request)
  {
    parse_str($rawInput, $requestParsed);
    return array_merge($request, $requestParsed);
  }
}