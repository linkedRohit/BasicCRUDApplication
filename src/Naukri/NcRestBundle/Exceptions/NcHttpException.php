<?php

namespace Naukri\NcRestBundle\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NcHttpException extends HttpException {
    
    private $customData;

    public function __construct($statusCode, $message = null, $previous = null, $headers = array(), $code = 0, $customData = "") {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
        $this->customData = $customData;
    }

    public function getCustomData(){
      return $this->customData;
    }
}
