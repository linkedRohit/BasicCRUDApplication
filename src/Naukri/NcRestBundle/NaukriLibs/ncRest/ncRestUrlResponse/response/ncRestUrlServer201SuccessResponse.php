<?php

/**
 * @author
 */

/**
 * ncRestUrlServer201SuccessResponse
 */
class ncRestUrlServer201SuccessResponse extends ncRestUrlResponse
{

    public function __construct($arrResponse, $format = 'json') {
        #parent::__construct($format);
        $this->responseHeaders = array(
          "Status" => "201 New resource created",
          "Content-Type" => "application/$format"
        );

        $responseCreatorHelper = new ResponseCreatorHelper();
        $status = 201;
        $this->responseBody = $responseCreatorHelper->getResponseBody($arrResponse, $format, $status);
    }

    public function isSuccessful() {
        return true;
    }

}
