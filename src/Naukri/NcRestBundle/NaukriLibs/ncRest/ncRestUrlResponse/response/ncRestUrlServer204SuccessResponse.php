<?php
/**
 * @author
 */

/**
 * ncRestUrlServer204SuccessResponse
 */

class ncRestUrlServer204SuccessResponse extends ncRestUrlResponse
{

  public function __construct($successArr, $format = 'xml') {
    #parent::__construct($format);
    $this->responseHeaders = array(
      "Status" => "204  resource updated",
      "Content-Type" => "application/$format"
    );
  }

  public function isSuccessful(){
    return true;
  }

}
