<?php

namespace Joppli\Parser;

interface Parser
{
  public function parse(string $path) : array;
}
