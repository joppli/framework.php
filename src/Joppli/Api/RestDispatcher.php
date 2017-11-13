<?php

namespace Joppli\Api;

use
Joppli\Request\Aware\RequestAware,
Joppli\Request\Aware\RequestAwareTrait;

class RestDispatcher implements Dispatcher, CrudDispatcher, RequestAware
{
  use RequestAwareTrait;

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

  public function create()
  {
    $this->badRequest();
  }

  public function retrieve()
  {
    $this->badRequest();
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
