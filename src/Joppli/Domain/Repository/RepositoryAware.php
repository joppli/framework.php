<?php

namespace Joppli\Domain\Repository;

interface RepositoryAware
{
  public function setRepository(RepositoryLocator $repository);
}
