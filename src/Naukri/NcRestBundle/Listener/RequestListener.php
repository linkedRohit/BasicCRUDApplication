<?php

namespace Naukri\NcRestBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Naukri\NcRestBundle\Controller\NcApiControllerInterface;
use ncRestUrlResponseException;
use ncRestCommonFunc;
use Naukri\NcRestBundle\Resources\model\Constants;
use Naukri\NcRestBundle\Utility\ApiResponseUtil;
/*
 * @author("Nitin Birdi")
 */
class RequestListener {

    public function onKernelRequest(FilterControllerEvent $event) {
        $controller = $event->getController();
        $controller = $controller[0];
        if ($controller instanceof NcApiControllerInterface) {
            $objRequest = $controller->get('request');
            $objHeaders = $objRequest->headers;
            $objServer = $objRequest->server;
            $reqMethod = $objServer->get('REQUEST_METHOD');
            $acceptType = $objHeaders->get('accept');
            $contentType = $objHeaders->get('Content-Type');
            $contentType = preg_replace('/\s+/', '', $contentType);
            $methodType =$objHeaders->get('x-http-method-override');
            $arrPayLoad = ApiResponseUtil::getPayloadArray($controller->get('request')->getContent(),$contentType);
            #$arrJsonPayLoad = json_decode($controller->get('request')->getContent(),1);
            if($arrPayLoad){
              foreach($arrPayLoad as $key=>$value){
                  $event->getRequest()->request->set($key,$value);
              }
            }
            $event->getRequest()->request->set("clientId",$objHeaders->get("clientId"));
            $event->getRequest()->request->set("Authorization",$objHeaders->get("Authorization"));
            $event->getRequest()->query->set("Authorization",$objHeaders->get("Authorization"));
            $event->getRequest()->request->set("MethodType",$methodType);
            $arrAllowedTypes = explode(",",strtolower(Constants::ALLOWED_TYPES));
            $acceptType = ncRestCommonFunc::parseAcceptType($acceptType, $arrAllowedTypes);
            if ($acceptType == '') {
//                throw new ncRestUrlResponseException(null, 'Invalid Header Accept Type', 406);
            }
            if(!in_array(strtolower($contentType),$arrAllowedTypes) && $reqMethod!="GET"){  
//             throw new ncRestUrlResponseException(null, 'Unsupported Media Type', 415);
            }
        }
    }

}
