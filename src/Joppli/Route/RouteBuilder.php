<?php

namespace Joppli\Route;

use
Joppli\Config\Aware\ConfigAware,
Joppli\Config\Aware\ConfigAwareTrait,
Joppli\Config\Config,
Joppli\Locator\Locator,
Joppli\Route\Validator\RouteValidator;

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
    $route = $this->walk($this->config->router);

    $dispatchers = array_merge(
      $route['dispatchers.pre']  ?? [],
      $route['dispatchers']      ?? [],
      $route['dispatchers.post'] ?? []);

    return new Route($route['path'] ?? [], $route['deliverer'], $dispatchers);
  }

  protected function walk(
    Config  $tree,
    array   $route = [],
    array   $path  = []) : array
  {
    foreach($tree as $name => $item)
      if($this->isValid($item))
      {
        $context   = $path;
        $context[] = $name;
        $this->extend($route, $item, $context);

        if($item->children)
          $route = $this->walk($item->children, $route, $context);
      }

    return $route;
  }

  /**
   * Extends the route structure with the attributes from the item
   *
   * @param array &$route
   * @param Config $item
   * @param array $path
   */
  protected function extend(array &$route, Config $item, array $path)
  {
    foreach($item as $key => $value)
      switch($key)
      {
        case 'deliverer':
          $route[$key] = $item->{$key};
          break;

        case 'dispatchers':
          $route['path'] = $path;
          $route[$key]   = $item->{$key}->toArray();
          break;

        case 'dispatchers.pre':
        case 'dispatchers.post':
          $route[$key] = $route[$key] ?? [];
          array_push($route[$key], ...$item->{$key}->toArray());
          break;
      }
  }

  protected function isValid(Config $item) : bool
  {
    try
    {
      foreach ($item->policies ?? [] as $policy)
      {
        $validator = $this->getValidator($policy->validator);
        $validator->validate($policy);
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
    $class      = __NAMESPACE__.'\\Validator\\'.$validator.'Validator';
    $validator  = class_exists($class) ? $class : $validator;

    return $this->locator->get($validator);
  }
}
