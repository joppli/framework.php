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
    if(strtolower($_SERVER['CONTENT_TYPE']) == 'application/json')
      $requestParsed = json_decode($rawInput, true);

    else
      parse_str($rawInput, $requestParsed);

    return array_merge($request, $requestParsed);
  }
}
