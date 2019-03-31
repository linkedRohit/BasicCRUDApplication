<?php

namespace Naukri\NcRestBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception as SymfonyException;
use Naukri\NcRestBundle\Exceptions\ApiException;
use Naukri\NcRestBundle\Exceptions\NcHttpException;
use Naukri\NcRestBundle\Exceptions\UnsupportedFormatException;
use Naukri\NcRestBundle\Exceptions\UserNotAuthorizedException;
use Naukri\NcRestBundle\Utility\ApiResponseUtil;
use Naukri\NcRestBundle\Resources\model\Constants;

class ApiExceptionListener {

  private $container;
  
  public function __construct($serviceContainer){
      $this->container = $serviceContainer;
  }
  
  public function onKernelException(GetResponseForExceptionEvent $event){
    $request = $event->getRequest();
    $transactionId = $request->server->get("HTTP_X_TRANSACTION_ID");
    $GET_PARAMS_ARR = $request->query->all();
    $referer = $request->server->get('REQUEST_URI');
    
    $contentType = $request->headers->get('accept');
    $objNcRestResp = null;
    $format = ApiResponseUtil::getMappedContentType($contentType);

    $arrSupportedReferers = explode(",", NCREST_REFERER_URL_SUBSTR);
    $boolListen = 0;
    foreach($arrSupportedReferers as $suppReferer){
      if($boolListen = strpos($referer,$suppReferer)){
        break;
      }
    }
    $arrAllowedTypes = explode(",",Constants::ALLOWED_TYPES);    
    if($boolListen){
      $objException = $event->getException();
      try{
        $objLogger = \CentralLoggerManager::getInstance()->getLogger('apiError');
        
        $information = (string) $objException;
        $objLogger->log('NcRestException','',"HTTP_X_TRANSACTION_ID - ".$transactionId." ".'|XX|'.$information.'|XX|', 'critical_error', 4);
      }catch(\Exception $e){
      }
        $code = $objException->getCode();
        
        $message = $objException->getMessage();
        
        $customData = array();
        $additionalHeaders = array();
        if($objException instanceOf NcHttpException) {
            $customData = $objException->getCustomData();
            $additionalHeaders = $objException->getHeaders();
        }

        if($code == 401){
            $objNcRestResp = new \ncRestUrlUnauthorizedErrorResponse($message,$format,'',$customData);
        } else if($code == 403){
            $objNcRestResp = new \ncRestUrlServer403FailureResponse($message,$format,'',$customData);
        } else if($code == 406){
            $objNcRestResp = new \ncRestUrlServer406FailureResponse($message,$format);
        } else if($code == 415){
            $objNcRestResp = new UnsupportedFormatException($message,$format);
        } else if($objException instanceof ApiException){
            $objNcRestResp = new \ncRestUrlClientFailureResponse($objException->getValidationErrors(), $format, $objException->getCustomData(), $objException->getAppCode());
        } else if($objException instanceof SymfonyException\MethodNotAllowedHttpException){
             $objNcRestResp = new \ncRestUrlServer405FailureResponse($message,$format);
        } else if(($objException instanceof SymfonyException\NotFoundHttpException) || ($objException instanceof SymfonyException\RouteNotFoundException)){
            $objNcRestResp = new \ncRestUrlServer404FailureResponse($message,$format);
        } else {
            $objNcRestResp = new \ncRestUrlServerFailureResponse($message,$format);
        }
    } else if(in_array($contentType,$arrAllowedTypes)){
        if(strpos($event->getException()->getMessage(), "o route found")){
            $objNcRestResp = new \ncRestUrlServer404FailureResponse($message,$format);
        }
        $boolListen = 1;
    }
    if($boolListen){
      ApiResponseUtil::sendAndDisplayHeaders($objNcRestResp, $additionalHeaders);
    }
  }

  public static function shutDownHandler() {
        $error = error_get_last();
        if (isset($error)) {
            $type = $error['type'];
            if (!in_array($type, array(E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE, E_RECOVERABLE_ERROR))) {
                return;
            }
            $request = Request::createFromGlobals();
            $contentType = $request->getContentType();
            $format = ApiResponseUtil::getMappedContentType($contentType);
            $message = 'Type: ' . $error['type'] . '|Message: ' . $error['message'] . '|File: ' . $error['file'] . '|Line: ' . $error['line'];
            $objLogger = \CentralLoggerManager::getInstance()->getLogger('apiError');
            $objLogger->log('NcRestException', NCREST_APP_CODE, '|XX|' . $message . '|XX|', 'critical_error', 4);
            $objNcRestResp = new \ncRestUrlServerFailureResponse($message, $format);
            ApiResponseUtil::sendAndDisplayHeaders($objNcRestResp);
        }
    }

}
