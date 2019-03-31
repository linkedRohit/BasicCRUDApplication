<?php

namespace Naukri\JobPostingGatewayBundle\Util\Auth;

use JMS\DiExtraBundle\Annotation as DI;
use Naukri\JobPostingGatewayBundle\Resources\model\Recruiter;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @DI\Service("jpsso.security.user.provider")
 */
class JPSSOUserProvider implements UserProviderInterface
{
    public function loadUserByUsername($username) { 
    
        $usrData = explode("_", $username);
        $clientId = $usrData[1];
        $recruiterId = $usrData[0];
        
        return $recruiterId;
    }

    public function refreshUser(UserInterface $user) { 
    
    
        if (!$user instanceof Recruiter) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
        //TODO: Check if we need to do anything here
        return $user;
    }

    public function supportsClass($class) { 
    
    
        return $class === Recruiter;
    }
}

