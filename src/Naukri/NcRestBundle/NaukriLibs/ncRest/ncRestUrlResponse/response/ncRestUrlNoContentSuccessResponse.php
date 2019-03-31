<?php

/**
 * @author
 */

/**
 * ncRestUrlNoContentSuccessResponse class
 */
class ncRestUrlNoContentSuccessResponse extends ncRestUrlResponse
{

    public function __construct($contentType = 'json') {
        $this->responseHeaders = array(
          "Status" => "204 No Content",
          "Content-Type" => "application/$contentType"
        );

        $responseCreatorHelper = new ResponseCreatorHelper();
        $status = 204;
        $this->responseBody = $responseCreatorHelper->getResponseBody($arrResponse, $contentType, $status);
    }

    public function isSuccessful() {
        return true;
    }


}
