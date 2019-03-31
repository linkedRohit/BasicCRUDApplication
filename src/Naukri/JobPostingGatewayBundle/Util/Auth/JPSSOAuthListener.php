<?php

namespace Naukri\JobPostingGatewayBundle\Util\Auth;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\Templating\DelegatingEngine;
use Naukri\JobPostingGatewayBundle\Resources\model\Recruiter;
use Naukri\JobPostingGatewayBundle\Util\Auth\JPSSOToken;
use Symfony\Component\HttpFoundation\Cookie;

class JPSSOAuthListener implements ListenerInterface
{
    protected $securityContext;
    protected $authenticationManager;
    protected $templater;
    protected $logger;
    protected $clientUtil;
    
    public function __construct(SecurityContextInterface $securityContext, AuthenticationManagerInterface $authenticationManager, DelegatingEngine $templater) { 
    
        $this->securityContext = $securityContext;
        $this->authenticationManager = $authenticationManager;
        $this->templater = $templater;
    }

    public function setLogger($logger) { 
    
        $this->logger = $logger;
    }
    
    public function setClientUtil($clientUtil) { 
    
        $this->clientUtil = $clientUtil;
    }
   
    public function handle(GetResponseEvent $event) {
        try {
            $controllerRoute = $event->getRequest()->attributes->get('_route');
            $requestMethod = $event->getRequest()->getMethod();
            $queryParams = $event->getRequest()->query;
//            $offlineParentFlag = stristr($event->getRequest()->headers->get('referer'), "https://posting.naukri.com/jobposting/offline_bulk/jp_getdata_offl.php");
            $cookies = $event->getRequest()->cookies;
            //    if($offlineParentFlag && $cookies->get('opsUser')) {               
                    $opsUser = json_decode($cookies->get('opsUser'), true);
                    $sessionId = $opsUser['sessionId'];
                    if( 1 || $sessionId) {
                        $authStatus = 1;//$this->authenticationManager->authenticateOfflineUser($sessionId);
                        if($authStatus) {
                            $user = new Recruiter();
                            $user->setId($opsUser["userId"]);
                            $user->setCompanyId(168613);//$opsUser["companyId"]); 
        	            $user->setCompanyId($opsUser["companyId"]);
    	                    $user->setCompanyName('Offline Company');
                       	    $user->setEmailId("rohit.sharma1@naukri.com");
        	            $token = new JPSSOToken($user);
                            $this->securityContext->setToken($token);
                        } else {
                            // Do we really need this check .... :)
                            $req = $event->getRequest();
                            $currentPath = urlencode($req->getScheme()."://".$req->getHost().':'.$req->getPort().$req->getRequestUri());
                            $url=_AUTH_URL."?msg=TO&URL=".$currentPath;
                            //
                            $response = new RedirectResponse($url);
   
                            $event->setResponse($response);
                        }
                    }
        }  catch (AuthenticationException $e) {
            echo $e->getMessage();die;
        }
    }

}
