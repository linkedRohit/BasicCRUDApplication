<?php
/**
 * @author
 */

/**
 * ncRestUrlServer403FailureResponse
 */

class ncRestUrlServer403FailureResponse extends ncRestUrlFailureResponse
{
  public function __construct($exceptionError, $format, $appCode='', $customData = array()) {
    parent::__construct($format,$appCode);
    $this->responseHeaders = array(
      "Status" => "403 Forbidden",
      "Content-Type" => "application/$format"
    );
    $cCode = 4031;
    if($customData["customCode"]){
      $cCode = $customData["customCode"];
      unset($customData);
    }
    $responseBodyArray = $this->getData(403, 'Forbidden', $cCode, $exceptionError, array(), $customData);
    $this->responseBody = $this->getConvertedData($responseBodyArray);
  }
}
