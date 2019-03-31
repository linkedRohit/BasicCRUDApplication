<?php

namespace Naukri\NcRestBundle\Exceptions;
use Exception;

class UserNotAuthorizedException extends \ncRestUrlUnauthorizedErrorResponse {

  public function __construct($exceptionError, $format, $appCode='', $customData = array()) {
    parent::__construct($exceptionError, $format, $appCode='', $customData);
  }

}

