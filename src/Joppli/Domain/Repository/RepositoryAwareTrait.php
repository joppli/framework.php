<?php

namespace Joppli\Domain\Repository;

trait RepositoryAwareTrait
{
  /**
   * @var RepositoryLocator
   */
  protected $repository;

  public function setRepository(RepositoryLocator $repository)
  {
    $this->repository = $repository;
  }
}
