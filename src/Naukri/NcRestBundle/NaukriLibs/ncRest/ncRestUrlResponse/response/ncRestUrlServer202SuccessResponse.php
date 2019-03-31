<?php

/**
 * @author
 */

/**
 * ncRestUrlServer202SuccessResponse. Request has been accepted to process later. 
 */
class ncRestUrlServer202SuccessResponse extends ncRestUrlResponse
{

    public function __construct($arrResponse, $format = 'json') {
        $this->responseHeaders = array(
          "Status" => "202 Accepted",
          "Content-Type" => "application/$format"
        );

        if (!empty($arrResponse)) {
            $responseCreatorHelper = new ResponseCreatorHelper();
            $status = 202;
            $this->responseBody = $responseCreatorHelper->getResponseBody($arrResponse, $format, $status);
        }
    }

    public function isSuccessful() {
        return true;
    }

}
