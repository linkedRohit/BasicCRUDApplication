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

class JPSSOOfflineAuthListener implements ListenerInterface
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
            $token = $this->securityContext->getToken();
            if (isset($token)) {
                 $user = $token->getUser();
            }
            if (!isset($user) ) {
                $user = new Recruiter();
                $user->setSsoToken('');
            }
            $isGnbController = false;
            $token = $this->authenticationManager->authenticate(new JPSSOToken($user));
            $this->securityContext->setToken($token);
            $user = $token->getUser();
            if ( !$user->getId() || !$token || !$token->isAuthenticated() ) {
                $isGnbController = $this->getIfGnbController($controllerRoute);
                if($isGnbController) {
                    echo json_encode(array('status'=>'INVALID_SESSION', 'url'=>''));
                    exit(0);
                }

                // Do we really need this check .... :)
                $req = $event->getRequest();
                $currentPath = urlencode($req->getScheme()."://".$req->getHost().':'.$req->getPort().$req->getRequestUri());
                $url=_AUTH_URL."?msg=TO&URL=".$currentPath;
                $response = new RedirectResponse($url);
  
                $event->setResponse($response);
            }
        }  catch (AuthenticationException $e) {
            echo $e->getMessage();die;
        }
    }

    private function getIfGnbController($controllerRoute) {
        if(preg_match('/(components_)/',$controllerRoute)){
            return true;
        }
        return false;
    }

}
