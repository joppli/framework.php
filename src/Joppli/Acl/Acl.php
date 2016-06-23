<?php

namespace Joppli\Acl;

class Acl
{
  protected
    $fallback = true,
    $granted  = [],
    $denied   = [];

  /**
   * The deny list is absolute above the grant list. Add a deny rule only if
   * an exception to the grant rules is needed.
   *
   * @param string $role
   * @param string $resource
   * @param string $operation
   */
  public function deny(string $role, string $resource, string $operation)
  {
    $this->compose($this->denied, $role, $resource, $operation);
  }

  /**
   * @param string $role
   * @param string $resource
   * @param string $operation
   */
  public function grant(string $role, string $resource, string $operation)
  {
    $this->compose($this->granted, $role, $resource, $operation);
  }

  /**
   * @param array &$list
   * @param string $role
   * @param string $resource
   * @param string $operation
   */
  private function compose(
    array &$list,
    string $role,
    string $resource,
    string $operation)
  {
    if(!in_array($role, $list[$resource][$operation] ?? []))
      $list[$resource][$operation][] = $role;
  }

  /**
   * @param string $role
   * @param string $resource
   * @param string $operation
   * @return bool
   *
   * if value don't exist in the grant or deny lists, a fallback is used. The
   * fallback can be changed with `setGrantedFallback`
   */
  public function isGranted(
    string $role,
    string $resource,
    string $operation) : bool
  {
    if(isset($this->denied[$resource])
    && isset($this->denied[$resource][$operation])
    && in_array($role, $this->denied[$resource][$operation]))
      return false;

    if(isset($this->granted[$resource]))
      return isset($this->granted[$resource][$operation])
        ? in_array($role, $this->granted[$resource][$operation])
        : false;

    return $this->fallback;
  }

  /**
   * @param bool $fallback The fallback value if no resource is added to
   * perform the validation on..
   */
  public function setFallback(bool $fallback)
  {
    $this->fallback = $fallback;
  }
}