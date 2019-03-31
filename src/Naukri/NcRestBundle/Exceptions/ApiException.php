<?php

namespace Naukri\NcRestBundle\Exceptions;
use Exception;

class ApiException extends Exception {
    
    private $arrErrors;
    private $appCode;
    private $customData;

    public function __construct($arrErrors, $customData = "", $appCode = "") {
        parent::__construct("Validations Failed");
        $this->arrErrors = $arrErrors;
        $this->customData = $customData;
        $this->appCode = $appCode;
    }
    
    public function getValidationErrors(){
        return $this->arrErrors;
    }

    public function getAppCode(){
      return $this->appCode;
    }

    public function getCustomData(){
      return $this->customData;
    }
}
