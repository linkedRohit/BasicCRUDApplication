<?php
/**
 * @author
 */

/**
 * ncRestUrlResponseHandler class
 */

abstract class ncRestUrlResponseHandler
{
    protected $headers;
    protected $assessmentData;
    protected $objncRestUrlResponseValidator;
    private $methodName;

    public function __construct(ncRestUrlResponseRequest $objncRestUrlResponseRequest,  $methodName) {
        $this->headers = $objncRestUrlResponseRequest->getHeaders();
        $this->objncRestUrlResponseValidator = $this->getncRestUrlResponseValidator($objncRestUrlResponseRequest);
        $this->methodName = $methodName;
        $this->contentType = $objncRestUrlResponseRequest->getHeaderContentType();
    }

    protected function getncRestUrlResponseValidator(ncRestUrlResponseRequest $objncRestUrlResponseRequest) {
        return new ncRestUrlResponseValidator($objncRestUrlResponseRequest);
    }

    public function processRequest() {
        try {
            $requestValidationErrors = array();
            if ($this->isValidRequest($requestValidationErrors)) {
                $methodName = $this->methodName;
                return $this->$methodName();
            }
            return $this->createFailureResponseFromValidationErrors($requestValidationErrors);
        } catch(Exception $e) {
            $errMsg = 'Service is not available yet, Please try again later';
            return $this->createFailureResponseFromExceptionErrors($errMsg);
        }
    }

    protected function isValidRequest(&$validationErrors) {
        return $this->objncRestUrlResponseValidator->isValidRequest($validationErrors);
    }

    protected function createSuccessfulResponse($jobDetailsSuccessfulResult, $selfUrl = '', $isMultipleResponse = false) {
        return new ncRestUrlSuccessResponse($jobDetailsSuccessfulResult,$this->contentType,$selfUrl,$isMultipleResponse);
    }

    protected function createSuccessful201Response($jobDetailsSuccessfulResult) {
        return new ncRestUrlServer201SuccessResponse($jobDetailsSuccessfulResult,$this->contentType);
    }

    protected function createFailureResponseFromValidationErrors($requestValidationErrors, $appCode = '', $customData = array()) {
        return new ncRestUrlClientFailureResponse($requestValidationErrors, $this->contentType, $appCode, $customData);
    }

    protected function createFailureResponseFrom404Errors($exceptionErrors, $appCode = '', $customData = array()) {
        return new ncRestUrlServer404FailureResponse($exceptionErrors, $this->contentType, $appCode, $customData);
    }

    protected function createFailureResponseFrom403Errors($exceptionErrors, $appCode = '', $customData = array()) {
        return new ncRestUrlServer403FailureResponse($exceptionErrors, $this->contentType, $appCode, $customData);
    }

    public function createFailureResponseFrom405Errors($exceptionErrors, $appCode = '', $customData = array()) {
        return new ncRestUrlServer405FailureResponse($exceptionErrors, $this->contentType, $appCode, $customData);
    }

    protected function createFailureResponseFromExceptionErrors($exceptionErrors, $appCode = '', $customData = array()) {
        return new ncRestUrlServerFailureResponse($exceptionErrors, $this->contentType, $appCode, $customData);
    }

    protected function createFailureResponseFromBadRequestErrors($errorMsg, $appCode = '', $customData = array()) {
        return new ncRestUrlBadRequestFailureResponse($errorMsg, $this->contentType, $appCode, $customData);
    }

    protected function createFailureResponseFromUnauthorizedErrors($errorMsg, $appCode = '', $customData = array()) {
        return new ncRestUrlUnauthorizedErrorResponse($errorMsg, $this->contentType, $appCode, $customData);
    }

    protected function createNoContentSuccessResponse() {
        return new ncRestUrlNoContentSuccessResponse($this->contentType);
    }

    protected function createRedirectResponseFrom304() {
        return new ncRestUrlServer304RedirectResponse($this->contentType);
    }

}

