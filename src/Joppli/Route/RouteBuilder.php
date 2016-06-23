<?php

namespace Joppli\Route;

use Joppli\Config\Aware\ConfigAware;
use Joppli\Config\Aware\ConfigAwareTrait;
use Joppli\Config\Config;
use Joppli\Locator\Locator;
use Joppli\Route\Validator\RouteValidator;

class RouteBuilder implements ConfigAware
{
  use ConfigAwareTrait;

  protected $locator;

  public function __construct(Locator $locator)
  {
    $this->locator = $locator;
  }

  public function build() : Route
  {
    $structure['dispatchers'] = [];
    $structure['operations']  = [];
    $this->walk($structure, $this->config->route);

    return new Route(
      $structure['resource']  ?? '',
      array_unique($structure['operations']),
      $structure['deliverer'] ?? '',
      array_unique($structure['dispatchers']));
  }

  protected function walk(array &$route, Config $tree)
  {
    foreach ($tree as $item)
    {
      if(!$this->isValid($item))
        continue;

      $this->extend($route, $item);

      if($item->child)
        $this->walk($route, $item->child);

      if($item->resource)
        break;
    }
  }

  /**
   * Extends the structure with the attributes from the item
   *
   * @param array &$route
   * @param Config $item
   */
  protected function extend(array &$route, Config $item)
  {
    if($item->resource)
    {
      $route['resource']   = $item->resource;
      $route['operations'] = [];
    }

    if($item->operation)
      $route['operations'][] = $item->operation;

    if($item->deliverer)
      $route['deliverer'] = $item->deliverer;

    if($item->dispatchers)
      $route['dispatchers'] = array_merge(
        $route['dispatchers'],
        $item->dispatchers->toArray());
  }

  protected function isValid(Config $item) : bool
  {
    try
    {
      foreach ($item->policy ?: [] as $policy)
      {
        $validator = $this->getValidator($policy->validator);
        $validator->validate($policy->options);
      }

      return true;
    }
    catch(Validator\Exception\ValidatorException $e)
    {
      return false;
    }
  }

  protected function getValidator(string $validator) : RouteValidator
  {
    return $this->locator->get($this->composeValidatorName($validator));
  }

  protected function composeValidatorName(string $validator) : string
  {
    $ns = __NAMESPACE__.'\\Validator\\';
    return class_exists($ns.$validator)
      ? $ns.$validator
      : $validator;
  }
}