<?php
/**
 * @author
 */

/**
 * ncRestUrlBadRequestFailureResponse
 */

class ncRestUrlBadRequestFailureResponse  extends ncRestUrlFailureResponse
{
    public function __construct($errorMessage, $format, $appCode = '', $customData = array()) {
        parent::__construct($format, $appCode);
        $this->responseHeaders = array(
            "Status" => "400 Bad Request",
            "Content-Type" => "application/$format"
        );

        $responseBodyArray = $this->getData(400, 'Validation Error', 4001, $errorMessage, array(), $customData);
        $this->responseBody = $this->getConvertedData($responseBodyArray);
    }
}
