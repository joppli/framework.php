<?php

namespace Joppli\Api;

interface CrudDispatcher
{
  public function create();
  public function retrieve();
  public function update();
  public function delete();
}
