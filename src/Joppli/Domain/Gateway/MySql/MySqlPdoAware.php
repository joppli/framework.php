<?php

namespace Joppli\Domain\Gateway\MySql;

use PDO;

interface MySqlPdoAware
{
  public function setMySqlPdo(PDO $mysql);
}
