<?php
/**
 * @author
 */

/**
 * ncRestUrlServer404FailureResponse
 */

class ncRestUrlServer404FailureResponse extends ncRestUrlFailureResponse
{
    public function __construct($exceptionError, $format, $appCode='', $customData = array()) {
        parent::__construct($format,$appCode);
        $this->responseHeaders = array(
            "Status" => "404 Not Found",
            "Content-Type" => "application/$format"
        );

        $responseBodyArray = $this->getData(404, 'Not Found', 4041, $exceptionError, array(), $customData);
        $this->responseBody = $this->getConvertedData($responseBodyArray);
    }
}
