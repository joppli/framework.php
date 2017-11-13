<?php

namespace Joppli\Api;

use
Joppli\Request\Aware\RequestAware,
Joppli\Request\Aware\RequestAwareTrait,
Joppli\Response\Aware\ResponseAware,
Joppli\Response\Aware\ResponseAwareTrait;



abstract class RestDispatcher implements Dispatcher, CrudDispatcher, RequestAware, ResponseAware
{
  use RequestAwareTrait, ResponseAwareTrait;

  public function dispatch()
  {
    switch($this->request->getMethod())
    {
      case 'post'   : $this->create();    break;
      case 'get'    : $this->retrieve();  break;
      case 'put'    : $this->update();    break;
      case 'delete' : $this->delete();    break;

      default:
        throw new Exception\BadRequestException(
          'invalid method: '.$this->request->getMethod());
    }
  }

  public function getOperationName() {
    switch($this->request->getMethod())
    {
      case 'post'   : return 'create';
      case 'get'    : return 'retrieve';
      case 'put'    : return 'update';
      case 'delete' : return 'delete';
      default:
        return 'unknown';
    }
  }

  //Get arguments not stating by '_'
  public function getQueryArguments() {
    $r = [];
    foreach ($this->request->getArguments() as $key => $value) {
      if(substr($key, 0, 1) != '_'){
        $r[$key] = $value;
      }
    }
    return $r;
  }

  public function getSortArgument() {
    if(!$this->request->hasArg('_sort')){
      return [];
    }
    $r = array();
    foreach (explode(',', $this->request->getArg('_sort')) as $elem) {
      $e = explode(':', $elem);
      $r[$e[0]] = count($e) > 1 ? $e[1] : '';
    }
    return $r;
  }

  public abstract function getResourceName();

  public function create()
  {
    $this->badRequest();
  }

  public function retrieve()
  {
    $this->badRequest();
  }

  public function setCountHeader($count){
    $this->response->addHeader('X-total-count: ' . $count);
  }

  public function update()
  {
    $this->badRequest();
  }

  public function delete()
  {
    $this->badRequest();
  }

  protected function badRequest()
  {
    $method = $this->request->method;
    $msg    = 'method: "'.$method.'" is not implemented for: "'.__CLASS__.'"';
    throw new BadRequestException($msg);
  }
}
