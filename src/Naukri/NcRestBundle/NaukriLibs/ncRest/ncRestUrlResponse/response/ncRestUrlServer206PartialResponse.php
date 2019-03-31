<?php

/**
 * @author
 */

/**
 * ncRestUrlServer206PartialResponse class
 */
class ncRestUrlServer206PartialResponse extends ncRestUrlResponse
{

    public function __construct(array $arrResult, $format = 'json', $selfUrl = '', $isMultipleResponse = false) {
        $contentType = $format;
        $this->responseHeaders = array(
          "Status" => "206 Partial Content",
          "Content-Type" => "application/$contentType"
        );

        if ($isMultipleResponse) {
            $arrResponse["list"] = $arrResult;
            //$arrResponse["href"] = $selfUrl;
        } else {
            //$arrResult["href"] = $selfUrl;
            $arrResponse = $arrResult;
        }

        $responseCreatorHelper = new ResponseCreatorHelper();
        $status = 206;
        $this->responseBody = $responseCreatorHelper->getResponseBody($arrResponse, $format, $status);
        if ("form-data" == $format)  {
            $this->responseHeaders = $responseCreatorHelper->getResponseHeader($status);
        }
    }

    public function isSuccessful() {
        return true;
    }

    

}
