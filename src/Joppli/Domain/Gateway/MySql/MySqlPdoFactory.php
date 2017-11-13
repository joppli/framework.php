<?php

namespace Joppli\Domain\Gateway\MySql;

use
PDO,
PDOException,
Joppli\Config\Aware\ConfigAware,
Joppli\Config\Aware\ConfigAwareTrait;

class MySqlPdoFactory implements ConfigAware
{
  use ConfigAwareTrait;

  public function create()
  {
    $dsn  = 'mysql:host='.$this->config->mysql->host;
    $dsn .= ';dbname='.$this->config->mysql->db;
    $dsn .= ';charset='.$this->config->mysql->charset;
    $user = $this->config->mysql->user;
    $pass = $this->config->mysql->password;

    try
    {
      return new PDO($dsn, $user, $pass);
    }
    catch (PDOException $e)
    {
      // @todo: set specific exception
      throw $e;
    }
  }
}
