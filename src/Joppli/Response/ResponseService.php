<?php

namespace Joppli\Response;

class ResponseService
{
  /**
   * Sets the status code
   *
   * @param int $code
   */
  public function setStatus(int $code)
  {
    http_response_code($code);
  }

  /**
   * Sets a defined header
   *
   * @param string $header
   */
  public function addHeader(string $header)
  {
    header($header);
  }

  /**
   * Output
   *
   * @param string $output
   */
  public function output(string $output)
  {
    echo $output;
  }
}