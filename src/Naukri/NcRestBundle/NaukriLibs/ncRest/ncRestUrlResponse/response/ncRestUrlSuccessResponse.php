<?php

/**
 * @author
 */

/**
 * ncRestUrlSuccessResponse class
 */
class ncRestUrlSuccessResponse extends ncRestUrlResponse
{

    public function __construct(array $arrResult, $format = 'json', $selfUrl = '', $isMultipleResponse = false) {
        $this->responseHeaders = array(
          "Status" => "200 OK",
          "Content-Type" => "application/$format"
        );

        if ($isMultipleResponse) {
            $arrResponse["list"] = $arrResult;
            //$arrResponse["href"] = $selfUrl;
        } else {
            //$arrResult["href"] = $selfUrl;
            $arrResponse = $arrResult;
        }

        $responseCreatorHelper = new ResponseCreatorHelper();
        $status = 200;
        $this->responseBody = $responseCreatorHelper->getResponseBody($arrResponse, $format, $status);
        if ("form-data" == $format)  {
            $this->responseHeaders = $responseCreatorHelper->getResponseHeader($status);
        } else if ($format == "attachment")  {
            $this->responseHeaders = $responseCreatorHelper->getResponseHeaderOfAttachment($arrResponse['fileName']);
        }
    }

    public function isSuccessful() {
        return true;
    }
    
}
