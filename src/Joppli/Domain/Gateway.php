<?php

namespace Joppli\Domain;

/**
 * The params domain and type can be the databasename and table name, or index
 * and type, or what ever..
 */
interface Gateway
{
  /**
   * @param $domain string
   * @param $type   string
   * @param $body   array   Structure of the item body
   * @param $id     string
   */
  public function create(
    string  $domain,
    string  $type,
    array   $body,
    string  $id = null);

  /**
   * The gateway takes no intrest in if there is unique columns in the driver,
   * it will always return an array, it's up to the repository/mapper to map
   * the response.
   *
   * @param $domain       string
   * @param $type         string
   * @param $id           string
   * @param $association  array   A map to what items should be retrieved
   * @param $order        array   ['col name' => 'asc|desc']
   * @param $from         int     Offset variable
   * @param $size         int     Limit variable
   */
  public function retrieve(
    string  $domain,
    string  $type,
    string  $id,
    array   $association,
    array   $order,
    int     $from,
    int     $size) : array;

  /**
   * @param $domain       string
   * @param $type         string
   * @param $body         array   Structure to percist
   * @param $id           string
   * @param $association  array   A map to what items should be updated
   */
  public function update(
    string  $domain,
    string  $type,
    array   $body,
    string  $id,
    array   $association);

  /**
   * @param $domain       string
   * @param $type         string
   * @param $id           string
   * @param $association  array   A map to what items should be deleted
   */
  public function delete(
    string  $domain,
    string  $type,
    string  $id,
    array   $association);
}
