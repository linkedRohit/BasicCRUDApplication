<?php

class ncRestUrlResponseFactory{

    private static $instance ;

    public static function getInstance() {
        if(! isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class();
        }
        return self::$instance;
    }

    private function __construct() {
    }


    public function showResponse(ncRestUrlParameter $objncRestUrlParameter = null, Exception $e = null){
        try {
            if (isset($e)) {
                throw $e;
            }

            $className=$objncRestUrlParameter->getClassName();
            $methodName = $objncRestUrlParameter->getMethodName();

            $allRequestHeaders = getallheaders();
            $authHeader = ncRestCommonFunc::parseAuthorisationHeader();
            $serviceHeaders = ncRestCommonFunc::parseAuthParams($authHeader['param']);
            $serviceHeaders['accept-type'] = $allRequestHeaders['Accept'];
            $ncRestUrlResponseRequest = new ncRestUrlResponseRequest($serviceHeaders, $objncRestUrlParameter);
            $apiWebHandler = new $className($ncRestUrlResponseRequest, $methodName);
            $apiResponse = $apiWebHandler->processRequest();
            $apiResponse->sendHeaders();
            $apiResponse->display();
            return $apiResponse;
        }
        catch (Exception $e) {
            $code = $e->getCode();
            $objNcRestUrlResponseFailureHandler = new ncRestUrlResponseFailureHandler();
            if($code == 406){
              $objFailureResponse = $objNcRestUrlResponseFailureHandler->createFailureResponseFrom406Errors($e->getMessage());
            }
            elseif($code == 404) {
              $objFailureResponse = $objNcRestUrlResponseFailureHandler->createFailureResponseFrom404Errors($e->getMessage());
            }
            elseif($code == 405) {
              $objFailureResponse = $objNcRestUrlResponseFailureHandler->createFailureResponseFrom405Errors($e->getMessage());
            }
            else {
              $objFailureResponse =  $objNcRestUrlResponseFailureHandler->createFailureResponseFromExceptionErrors($e->getMessage());
            }

            $objFailureResponse->sendHeaders();
            $objFailureResponse->display();
            exit(0);
        }
    }

    private function parseAuthorisationHeader() {
      $arrAuthorisationHeader = getallheaders();
      $authorisationHeader = $arrAuthorisationHeader['Authorization'];

      $tokenRegex = '/^(?P<schemeName>[\x21-\x27\x2A-\x2B\x2D\x2E0-9A-Z\x5E-z\x7C\7E]*)\s+(?P<param>.*)$/';
      preg_match($tokenRegex,$authorisationHeader,$output);

      return $output;
    }

    private function parseAuthParams($paramString) {
      $paramArrayFinal = array();
      $paramArray = explode(',',$paramString);

      foreach ($paramArray as $param) {
        $param = explode('=',$param);
        $paramArrayFinal[trim($param[0])] = trim($param[1],'"');
      }

      return $paramArrayFinal;
    }
}

