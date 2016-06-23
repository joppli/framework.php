<?php

namespace Joppli\Request\Aware;

use Joppli\Request\Request;

trait RequestAwareTrait
{
  /**
   * @var Request
   */
  protected $request;

  public function setRequest(Request $request)
  {
    $this->request = $request;
  }
}