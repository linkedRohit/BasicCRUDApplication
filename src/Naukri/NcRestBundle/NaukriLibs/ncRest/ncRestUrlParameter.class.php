<?php

class ncRestUrlParameter
{
    private $originalRequestData;
    private $requestContentType;
    private $arrMandatoryRequestData;
    private $arrOptionalRequestData;
    private $resourceName;
    private $methodName;
    private $requestMethod;
    private $className;

    public function setOriginalRequestData($originalRequestData) {
        $this->originalRequestData = $originalRequestData;
    }

    public function getOriginalRequestData() {
        return $this->originalRequestData;
    }

    public function setRequestContentType($requestContentType) {
        $this->requestContentType = $requestContentType;
    }

    public function getRequestContentType() {
        return $this->requestContentType;
    }

    public function setArrMandatoryRequestData($arrMandatoryRequestData) {
        $this->arrMandatoryRequestData = $arrMandatoryRequestData;
    }

    public function getArrMandatoryRequestData() {
        return is_array($this->arrMandatoryRequestData) ? $this->arrMandatoryRequestData : array();
    }

    public function setArrOptionalRequestData($arrOptionalRequestData) {
        $this->arrOptionalRequestData = $arrOptionalRequestData;
    }

    public function getArrOptionalRequestData() {
        return is_array($this->arrOptionalRequestData)?$this->arrOptionalRequestData:array();
    }

    public function setResourceName($resourceName) {
        $this->resourceName = $resourceName;
    }

    public function getResourceName() {
        return $this->resourceName;
    }

    public function setMethodName($methodName) {
        $this->methodName = $methodName;
    }

    public function getMethodName() {
        return $this->methodName;
    }

    public function setRequestMethod($requestMethod) {
        $this->requestMethod = $requestMethod;
    }

    public function getRequestMethod() {
        return $this->requestMethod;
    }

    public function setClassName($className) {
        $this->className = $className;
    }

    public function getClassName() {
        return $this->className;
    }
}

