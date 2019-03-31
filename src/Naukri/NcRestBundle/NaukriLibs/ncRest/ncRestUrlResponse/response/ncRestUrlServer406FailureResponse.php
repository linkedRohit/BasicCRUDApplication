<?php
/**
 * @author
 */

/**
 * ncRestUrlServer405FailureResponse
 */

class ncRestUrlServer406FailureResponse extends ncRestUrlFailureResponse
{

    public function __construct($exceptionError, $format, $appCode = '', $customData = array()) {
        parent::__construct($format, $appCode);

        $this->responseHeaders = array(
            "Status" => "406 Content negotiation failed",
            "Content-Type" => "application/$format"
        );

        $responseBodyArray = $this->getData(406, 'Content negotiation failed', 4061, $exceptionError, array(), $customData);
        $this->responseBody = $this->getConvertedData($responseBodyArray);
    }
}
