<?php

namespace Joppli\Request\Aware;

use Joppli\Request\Request;

interface RequestAware
{
  public function setRequest(Request $request);
}
