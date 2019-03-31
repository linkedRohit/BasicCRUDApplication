<?php

namespace Naukri\NcRestBundle\Utility;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiResponseUtil {

    public static $respForUt = "";

    public static function returnSuccessResponse($arrContent, $responseCode = 200, $responseFormat = "json", $arrAdditionalHeaders = array()){
        
        if (!$responseFormat) {
            $request = Request::createFromGlobals();
            $acceptType = $request->headers->get('Accept');
            $responseFormat = self::getMappedContentType($acceptType);
        }
        
        switch( $responseCode ){
            case 200:
                $objNcRestResp = new \ncRestUrlSuccessResponse($arrContent, $responseFormat);
                break;            
            case 201:
                $objNcRestResp = new \ncRestUrlServer201SuccessResponse($arrContent,$responseFormat);
                break;
            case 202:
                $objNcRestResp = new \ncRestUrlServer202SuccessResponse($arrContent, $responseFormat);
                break;
            case 204:
                $objNcRestResp = new \ncRestUrlNoContentSuccessResponse($responseFormat);
                break;
            case 206:
                $objNcRestResp = new \ncRestUrlServer206PartialResponse($arrContent, $responseFormat);
                break;
            case 303:
                $objNcRestResp = new \ncRestUrlServer303RedirectResponse($arrContent,$responseFormat);
                break;
            default:
                $objNcRestResp = new \ncRestUrlSuccessResponse($arrContent, $responseFormat);
        }
	self::sendAndDisplayHeaders($objNcRestResp, $arrAdditionalHeaders);
    }

    public static function returnFailureRespone($message, $responseCode, $format = 'json', $appCode = '', $customData = array()) {
        switch( $responseCode ){
            case 403:
                $objNcRestResp = new \ncRestUrlServer403FailureResponse($message, $format, $appCode, $customData);
                break;
            default:
                $objNcRestResp = new \ncRestUrlServerFailureResponse($message, $format, $appCode, $customData);
        }
        self::sendAndDisplayHeaders($objNcRestResp);
    }

    public static function sendAndDisplayHeaders($objNcRestResp, $arrAdditionalHeaders = array()) {
        if ($objNcRestResp) {
                $objNcRestResp->sendHeaders($arrAdditionalHeaders);
                $objNcRestResp->display();
		if (!defined('UT_COVERAGE')) {
                    die;//important in order to use ncRest
                } else {
                    self::$respForUt = $objNcRestResp->getResponse();
                }
	}
    }
    
    public static function getMappedContentType($contentType) {
        if (preg_match('/application\/xml/', $contentType, $matches)) {
            return 'xml';
        } elseif (preg_match('/text\/xml/', $contentType, $matches)) {
            return 'xml';
        } elseif (preg_match('/application\/json/', $contentType, $matches)) {
            return 'json';
        } elseif (preg_match('/application\/x-www-form-urlencode/', $contentType, $matches)) {
            return 'form';
        } else {
            return $contentType;
        }
    }

    public static function getPayloadArray($content, $format){
      $format = self::getMappedContentType($format);
      if($format == "xml"){
        return json_decode(json_encode((array) simplexml_load_string($content)),1);
      }
      return json_decode(utf8_decode($content),1);
    }
    
    public static function returnResponse($message, $responseCode, $format = 'json', $appCode = '', $customData = array(),$dataAlreadySeriealized = false) {
        switch( $responseCode ){
            case 403:
                $objNcRestResp = new \ncRestUrlServer403FailureResponse($message, $format, $appCode, $customData);
                break;
            case 400:
                $objNcRestResp = new \ncRestUrlClientFailureResponse($message,$format, $appCode, $customData, $dataAlreadySeriealized);
                break;
            case 500:
                $objNcRestResp = new \ncRestUrlServerFailureResponse($message, $format, $appCode, $customData);
            default:
                $objNcRestResp = new \ncRestUrlServerFailureResponse($message, $format, $appCode, $customData);
        }
        self::sendAndDisplayHeaders($objNcRestResp);
    }
}
