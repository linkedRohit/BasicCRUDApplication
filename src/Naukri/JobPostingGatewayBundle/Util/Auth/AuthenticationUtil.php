<?php

namespace Naukri\JobPostingGatewayBundle\Util\Auth;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * @author Rajendra
 */


/** 
 * @DI\Service("jp.auth.util") 
 */
class AuthenticationUtil
{
    
    /**
 * @DI\Inject("security.context") 
*/
    public $securityContext;
    
    public function getCurrentUser() { 
    
        $token = $this->securityContext->getToken();
        if ($token == null) {
            return null;
        }
        return $token->getUser();
    }

}

