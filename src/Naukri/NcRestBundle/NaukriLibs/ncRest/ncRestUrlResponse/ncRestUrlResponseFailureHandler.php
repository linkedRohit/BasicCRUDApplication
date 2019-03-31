<?php
/**
 * @author
 */

/**
 * ncRestUrlResponseFailureHandler class
 */

class ncRestUrlResponseFailureHandler
{
    private $contentType;

    public function __construct($contentType = '') {
      $this->contentType = $contentType == '' ?  ncRestCommonFunc::getAcceptType() : $contentType;
    }

    public function createFailureResponseFromValidationErrors($requestValidationErrors, $appCode = '', $customData = array()) {
      return new ncRestUrlClientFailureResponse($requestValidationErrors, $this->contentType, $appCode, $customData);
    }

    public function createFailureResponseFrom404Errors($exceptionErrors, $appCode = '', $customData = array()) {
      return new ncRestUrlServer404FailureResponse($exceptionErrors, $this->contentType, $appCode, $customData);
    }

    public function createFailureResponseFrom403Errors($exceptionErrors, $appCode = '', $customData = array()) {
      return new ncRestUrlServer403FailureResponse($exceptionErrors, $this->contentType, $appCode, $customData);
    }

    public function createFailureResponseFrom405Errors($exceptionErrors, $appCode = '', $customData = array()) {
      return new ncRestUrlServer405FailureResponse($exceptionErrors, $this->contentType, $appCode, $customData);
    }

    public function createFailureResponseFrom406Errors($exceptionErrors, $appCode = '', $customData = array()) {
      return new ncRestUrlServer406FailureResponse($exceptionErrors, $this->contentType, $appCode, $customData);
    }

    public function createFailureResponseFromExceptionErrors($exceptionErrors, $appCode = '', $customData = array()) {
      return new ncRestUrlServerFailureResponse($exceptionErrors, $this->contentType, $appCode, $customData);
    }

    public function createFailureResponseFromBadRequestErrors($errorMsg, $appCode = '', $customData = array()) {
      return new ncRestUrlBadRequestFailureResponse($errorMsg, $this->contentType, $appCode, $customData);
    }

    public function createFailureResponseFromUnauthorizedErrors($errorMsg, $appCode = '', $customData = array()) {
      return new ncRestUrlUnauthorizedErrorResponse($errorMsg, $this->contentType, $appCode, $customData);
    }
}
