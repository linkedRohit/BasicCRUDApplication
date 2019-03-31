<?php
/**
 * @author
 */

/**
 * ncRestUrlServer401FailureResponse
 */

class ncRestUrlServer401FailureResponse extends ncRestUrlFailureResponse
{
    public function __construct($exceptionError, $format, $appCode='', $customData = array()) {
        parent::__construct($format,$appCode);
        $this->responseHeaders = array(
            "Status" => "401 Unauthorized",
            "Content-Type" => "application/$format"
        );

        $responseBodyArray = $this->getData(401, 'Unauthorized', 4011, $exceptionError, array(), $customData);
        $this->responseBody = $this->getConvertedData($responseBodyArray);
    }
}
