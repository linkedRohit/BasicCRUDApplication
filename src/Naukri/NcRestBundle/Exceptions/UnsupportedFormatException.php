<?php

namespace Naukri\NcRestBundle\Exceptions;
use Exception;

class UnsupportedFormatException extends \ncRestUrlFailureResponse {

  private $arrErrors;

  public function __construct($exceptionError, $format, $appCode='', $customData = array()) {
    parent::__construct($format,$appCode);
    $this->responseHeaders = array(
      "Status" => "415 Unsupported Media Type",
      "Content-Type" => "application/$format"
    );
    $responseBodyArray = $this->getData(415, 'Unsupported Media Type', 4015, $exceptionError, array(), $customData);
    $this->responseBody = $this->getConvertedData($responseBodyArray);
  }

}

