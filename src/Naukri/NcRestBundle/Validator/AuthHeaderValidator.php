<?php

namespace Naukri\NcRestBundle\Validator;
use Naukri\NcRestBundle\Resources\model\Constants;
use ncRestCommonFunc;
use ncRestUrlResponseException;

class AuthHeaderValidator {
  public static function validateAuthHeader($authHeader){
    $arrAuthHeader = ncRestCommonFunc::parseAuthorisationHeader($authHeader);
    if($arrAuthHeader){
      $arrAuthHeaderParams = ncRestCommonFunc::parseAuthParams($arrAuthHeader['params']);
      if(!$arrAuthHeaderParams[Constants::SESSION_ID]){
        self::throwAuthHeaderException();
      }
    } else {
      self::throwAuthHeaderException();
    }
    return true;
  }

  public static function throwAuthHeaderException(){
    throw new ncRestUrlResponseException(null, 'Unauthorized', 401);
  }
}
