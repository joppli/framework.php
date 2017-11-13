<?php

namespace Joppli\Domain\Gateway\MySql;

use PDO

trait MySqlPdoAwareTrait
{
  /**
   * @var PDO
   */
  protected $mysql;

  public function setMySqlPdo(PDO $mysql)
  {
    $this->mysql = $mysql;
  }
}
