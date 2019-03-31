<?php
/**
 * @author
 */

/**
 * ncRestUrlClientFailureResponse
 */

class ncRestUrlClientFailureResponse  extends ncRestUrlFailureResponse
{
    public function __construct($validationErrors, $format, $appCode = '', $customData = array(), $dataAlreadySerialized = false) {
        parent::__construct($format, $appCode);

        $this->responseHeaders = array(
            "Status" => "400 Bad Request",
            "Content-Type" => "application/$format"
        );

        if ($dataAlreadySerialized) {
            $this->responseBody = $validationErrors;
        } else {
            $responseBodyArray = $this->getData(400, 'Validation Error', 4001, "Please check property values", $validationErrors, $customData);
            $this->responseBody = $this->getConvertedData($responseBodyArray);
        }

    }
}
