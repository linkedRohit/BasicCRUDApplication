<?php

namespace Naukri\JobPostingGatewayBundle\Resources\model;

use DateTime;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Naukri\JobPostingGatewayBundle\Resources\model\BaseModel;

class Recruiter extends BaseModel implements UserInterface,  EquatableInterface
{
   
    protected $id;
    protected $companyId;
    protected $emailId;
    protected $username;
    protected $ssoToken;
    protected $password;
    protected $companyName;
    protected $superUser;
    protected $ip;
    protected $status;
    protected $source;
    
    public function getCompanyName() { 
    
        return $this->companyName;
    }

    public function getSuperUser() { 
    
        return $this->superUser;
    }

    public function getIp() { 
    
        return $this->ip;
    }

    public function getStatus() { 
    
        return $this->status;
    }

    public function getSource() { 
    
        return $this->source;
    }

    public function setCompanyName($companyName) { 
    
        $this->companyName = $companyName;
    }

    public function setSuperUser($superUser) { 
    
        $this->superUser = $superUser;
    }

    public function setIp($ip) { 
    
        $this->ip = $ip;
    }

    public function setStatus($status) { 
    
        $this->status = $status;
    }

    public function setSource($source) { 
    
        $this->source = $source;
    }

    
    public function getSsoToken() { 
    
        return $this->ssoToken;
    }

    public function setSsoToken($ssoToken) { 
    
        $this->ssoToken = $ssoToken;
    }
    
    public function setUsername($username) { 
    
                
        $this->username=$username;
    }

    public function getUsername() { 
    
        return $this->username;
    }
    
    public function getId() { 
    
        return $this->id;
    }

    public function getCompanyId() { 
    
        return $this->companyId;
    }

    public function getEmailId() { 
    
        return $this->emailId;
    }

    public function setId($id) { 
    
        $this->id = $id;
    }

    public function setCompanyId($companyId) { 
    
        $this->companyId = $companyId;
    }

    public function setEmailId($emailId) { 
    
        $this->emailId = $emailId;
    }
    public function setPassword($password) { 
    
        $this->password = $password;
    }

    public function eraseCredentials() { 
    
        
    }

    public function getPassword() { 
    
        return $this->password;
    }

    public function getRoles() { 
    
        return array('ROLE_USER');
    }

    public function getSalt() { 
    
        return "";
    }

    public function isEqualTo(UserInterface $user) { 
    
        
    }

}

