<?php

namespace Naukri\NcRestBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();
$referer = $request->getRequestUri();
$arrSupportedReferers = explode(",", NCREST_REFERER_URL_SUBSTR);
foreach($arrSupportedReferers as $suppReferer){
  if(strpos($referer,$suppReferer)){
    register_shutdown_function(array('Naukri\NcRestBundle\Listener\ApiExceptionListener', 'shutDownHandler'));
  }
}

class NaukriNcRestBundle extends Bundle
{
}
