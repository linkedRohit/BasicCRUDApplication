<?php

namespace Naukri\JobPostingGatewayBundle\Util\Auth;

use JMS\DiExtraBundle\Annotation as DI;
use Naukri\JobPostingGatewayBundle\Resources\model\Recruiter;
use Naukri\JobPostingGatewayBundle\Util\Auth\JPSSOToken;
use SSOFactory;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @DI\Service("jpsso.security.authentication.provider")
 */
class JPSSOProvider implements AuthenticationProviderInterface
{
    private $userProvider;
   
    /**
     * @DI\InjectParams({ "userProvider" = @DI\Inject("jpsso.security.user.provider") })
     */
    public function __construct(UserProviderInterface $userProvider) { 
    
    
        $this->userProvider = $userProvider;
    }

    public function authenticate(TokenInterface $token) { 
        $forceAuthenticate = false;
        if ($forceAuthenticate) {            
            $user = new Recruiter();
            $user->setId(9876893);//1407
            $user->setCompanyId(168613);
            $user->setCompanyName('sanity7');
            $user->setEmailId("rajendra.bera@naukri.com");
            return new JPSSOToken($user);
        }
        $sessionManager = SSOFactory::getInstance()->getSessionManager('JP'); // Changes in Third Party
                
        $arrUserSession = $sessionManager->getAuthenticationStatus($token->getUser()->getSsoToken());
        //print_r($arrUserSession);die;
        if (!$arrUserSession['AUTH_CODE']) {
            $userSession = $arrUserSession;
        }
        
        $user = $token->getUser();        
        //print_r($user);die;
        if ($user->getId() != $userSession['USER_ID'] || $user->getCompanyId() != $userSession['COMPANY_ID']) {
            $user->setId($userSession['USER_ID']);
            $user->setCompanyId($userSession['COMPANY_ID']);
            $user->setUsername($userSession['USER_NAME']);
            $user->setSSOToken($userSession['CID']);
            $user->setCompanyName($userSession['COMPANY_NAME']);
            $user->setSuperUser($userSession['SUPER_USER']);
            $user->setIp($userSession['IP_ADDRESS']);
            $user->setStatus($userSession['STATUS']);
            $user->setSource($userSession['SOURCE']);
                        
        }
        return new JPSSOToken($user);

    }

    public function authenticateOfflineUser($sessionId) {
        return $this->validateSession($sessionId); 
    }

    public function validateCId($cid) {
        $obj = new Encryption();
//        $ObjJobStore = new jpJobStore();
        if (is_numeric($cid)) {
            $plainCId = $cid;
        } else {
            $plainCId = $obj->Decrypt($cid);
        }

        $uniqueid = $_COOKIE["SUMSID$plainCId"];
  //      $data = $ObjJobStore->validateCId($plainCId,$uniqueid);
        if(empty($data)) {
            file_put_contents('/var/log/apps/jobposting/OfflineAuthenticateError',' cid- '.$cid.' plainId- '.$plainCId.' uniqueId- '.$uniqueid,FILE_APPEND);
            return false;
        }
        return true;
    }


    /*
    Array
    (
    [SESSION_ID] => 22
    [USER_NAME] => jagga
    [USER_ID] => 1407
    [COMPANY_NAME] => Info Edge India Limited4
    [COMPANY_ID] => 1407
    [SUPER_USER] => 1
    [IP_ADDRESS] => 192.168.123.86
    [RDX_TIME] => DEFAULT
    [RDX_FLAG] => NEW_USER
    [SOURCE] => n
    [STATUS] => 0
    [CID] => 1c678ea17a437ff6e815673a17af9bd9897c2072abbaa812
    [AUTH_CODE] => 0
    )
    */
    public function supports(TokenInterface $token) { 
        return $token instanceof JPSSOToken;
    }
}

