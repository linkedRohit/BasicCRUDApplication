<?php

class ncRestCommonFunc{

  public static function parseAuthorisationHeader($authorisationHeader) {
    //$arrAuthorisationHeader = getallheaders();
    //$authorisationHeader = $arrAuthorisationHeader['Authorization'];

    $tokenRegex = '/^(?P<schemeName>[\x21-\x27\x2A-\x2B\x2D\x2E0-9A-Z\x5E-z\x7C\7E]*)\s+(?P<params>.*)$/';
    preg_match($tokenRegex,$authorisationHeader,$output);

    return $output;
  }

  public static function parseAuthParams($paramString) {
    $paramArrayFinal = array();
    $paramArray = explode(',',$paramString);

    foreach ($paramArray as $param) {
      $param = explode('=',$param);
      $paramArrayFinal[trim($param[0])] = trim($param[1],'"');
    }

    return $paramArrayFinal;
  }

/*
  public static function getAcceptType(){
    $allRequestHeaders = getallheaders();
    $authHeader = self::parseAuthorisationHeader();
    $serviceHeaders = self::parseAuthParams($authHeader['param']);
    $serviceHeaders['accept-type'] = $allRequestHeaders['Accept'];
    try{
      $ncRestUrlResponseRequest = new ncRestUrlResponseRequest($serviceHeaders, $objncRestUrlParameter);
      $acceptType = $ncRestUrlResponseRequest->getHeaderContentType();
    }catch(Exception $e1){ 
      $acceptType = 'json';
    }
    return $acceptType;
  }
 */
  public static function parseAcceptType($data, $arrAllowedType = array())
  {
    //$array = array();
    $items = explode(',', $data);
    foreach ($items as $item) {
      foreach($arrAllowedType as $allowedType){
        $elems = explode(';', $item);

        $acceptElement = array();
        list($type, $subtype) = explode('/', current($elems));
        $acceptElement['type'] = trim($type);
        $acceptElement['subtype'] = trim($subtype);

        list($allowedType, $allowedSubtype) = explode('/', $allowedType);
        if(trim($allowedType) == trim($type) && trim($allowedSubtype) == trim($subtype)){
          return $subtype;
        }

          /*$acceptElement['params'] = array();
          while(next($elems)) {
            list($name, $value) = explode('=', current($elems));
            $acceptElement['params'][trim($name)] = trim($value);
          }
          $array[] = $acceptElement;
           */
      }
    }
    return '';
  }

}
