<?php
/**
 * @author
 */

/**
 * ncRestUrlServerFailureResponse
 */

class ncRestUrlServerFailureResponse extends ncRestUrlFailureResponse
{
    public function __construct($exceptionError, $format, $appCode = '',  $customData = array()) {
        parent::__construct($format, $appCode);

        $this->responseHeaders = array(
            "Status" => "500 Internal Server Error",
            "Content-Type" => "application/$format"
        );

        $responseBodyArray = $this->getData(500, 'Internal Server Error', 5001, $exceptionError, array(), $customData);
        $this->responseBody = $this->getConvertedData($responseBodyArray);
    }
}
