<?php
/**
 * @author
 */

/**
 * ncRestUrlUnauthorizedErrorResponse
 */

class ncRestUrlUnauthorizedErrorResponse extends ncRestUrlFailureResponse
{
    public function __construct($exceptionError, $format, $appCode = '', $customData = array()) {
        parent::__construct($format,$appCode);

        require_once(dirname(__FILE__).'/../config/config.php');

        $responseAuthHeader = strtoupper(constant('REST_AUTHENTICATE_RESPONSE_HEADER'));
        $authResponseHeaderMsg = constant($responseAuthHeader."_WWW_Authenticate");
        $this->responseHeaders = array(
            "Status" => "401 Unauthorized",
            "Content-Type" => "application/$format",
            "WWW-Authenticate" => $authResponseHeaderMsg
        );

        $responseBodyArray = $this->getData(401, 'Unauthorized', 4011, $exceptionError, array(), $customData);

        $this->responseBody = $this->getConvertedData($responseBodyArray);

        /*if ($format == 'json') {
            $this->responseBody = $this->getJsonData($responseBodyArray);
        }
        else {
            $this->responseBody = $this->getXmlData($responseBodyArray);
        }*/
    }
}
