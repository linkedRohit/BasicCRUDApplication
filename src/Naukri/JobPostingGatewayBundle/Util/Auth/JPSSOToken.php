<?php

namespace Naukri\JobPostingGatewayBundle\Util\Auth;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;
use Symfony\Component\Security\Core\User\UserInterface;

class JPSSOToken extends AbstractToken
{
    
    public function __construct(UserInterface $user) { 
    
            
        //$email = $user->getEmailId();
        $this->setUser($user);
        //Assume authenticated only if a user has some roles
        $this->setAuthenticated(true);        
    }

    public function getCredentials() { 
    
    
        return '';
    }
}

