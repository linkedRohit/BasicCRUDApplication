<?php
/**
 * @author
 */

/**
 * ncRestUrlServer405FailureResponse
 */

class ncRestUrlServer405FailureResponse extends ncRestUrlFailureResponse
{

    public function __construct($exceptionError, $format, $appCode = '', $customData = array()) {
        parent::__construct($format, $appCode);

        $this->responseHeaders = array(
            "Status" => "405 Method Not Allowed",
            "Content-Type" => "application/$format"
        );

        $responseBodyArray = $this->getData(405, 'Method Not Allowed', 4051, $exceptionError, array(), $customData);
        $this->responseBody = $this->getConvertedData($responseBodyArray);
    }
}
