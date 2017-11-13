<?php

namespace Joppli\Response;

class Status
{
  const
  CONTINUE              = 100,
  SWITCHING_PROTOCOLS   = 101,
  OK                    = 200,
  CREATED               = 201,
  Accepted              = 202,
  NO_CONTENT            = 204,
  MOVED_PERMANENTLY     = 301,
  FOUND                 = 302,
  SEE_OTHER             = 303,
  NOT_MODIFIED          = 304,
  BAD_REQUEST           = 400,
  UNAUTHORIZED          = 401,
  PAYMENT_REQUIRED      = 402,
  FORBIDDEN             = 403,
  NOT_FOUND             = 404,
  METHOD_NOT_ALLOWED    = 405,
  CONFLICT              = 409,
  INTERNAL_SERVER_ERROR = 500,
  NOT_IMPLEMENTED       = 501,
  BAD_GATEWAY           = 502,
  GATEWAY_TIMEOUT       = 504
}