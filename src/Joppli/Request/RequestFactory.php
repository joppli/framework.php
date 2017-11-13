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
    if(in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT'])){
        $requestParsed = json_decode($rawInput, true);
        if($requestParsed === null){
          parse_str($rawInput, $requestParsed);
        }
    } else {
      parse_str($rawInput, $requestParsed);
    }
    return array_merge($request, $requestParsed);
  }
}
