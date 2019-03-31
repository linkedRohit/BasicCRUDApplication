<?php

class ncRestUrlResponseRequest
{
    protected $requestHeaders;
    protected $requestBody;
    protected $requestAcceptType;

    public function __construct($requestHeaders, $requestBody) {
        $this->requestHeaders = $requestHeaders;
        $this->requestBody = $requestBody;
        $this->requestAcceptType = $this->getHeaderAcceptType($requestHeaders['accept-type']);
    }

    private function getHeaderAcceptType($acceptTypes) {
      $arrAllowedType = array("application/xml", "application/json", "multipart/form-data");
      $acceptType = ncRestCommonFunc::parseAcceptType($acceptTypes, $arrAllowedType);
      if($acceptType == ''){
        throw new ncRestUrlResponseException(null, 'Invalid Header Accept Type', 406);
      }else{
        return $acceptType;
      }
    }

    public function getHeaderContentType() {
      return $this->requestAcceptType;
    }

    public function getHeaders() {
      return $this->requestHeaders;
    }

    public function getBody() {
      return $this->requestBody;
    }
}

