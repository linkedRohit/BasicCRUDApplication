<?php
namespace Naukri\JobPostingGatewayBundle\Resources\model\email;

use Naukri\JobPostingGatewayBundle\Resources\model\BaseModel;

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of UnsubscribedEmail
 *
 * @author Rajendra
 */
class UnsubscribedEmail extends BaseModel
{
    /**
    * @var integer
    **/
    private $id;

    /**
    * @var integer
    **/
    private $clientId;

    /**
    * @var integer
    **/
    private $candidateId;

    /**
    * @var string
    **/
    private $email;

    /**
    * @var \DateTime
    **/
    private $addedOn;
    
    public function getId() { 
    
        return $this->id;
    }

    public function setId($id) { 
    
        $this->id = $id;
    }

    public function getClientId() { 
    
        return $this->clientId;
    }

    public function setClientId($clientId) { 
    
        $this->clientId = $clientId;
    }

    public function getCandidateId() { 
    
        return $this->candidateId;
    }

    public function setCandidateId($candidateId) { 
    
        $this->candidateId = $candidateId;
    }

    public function getEmail() { 
    
        return $this->email;
    }

    public function setEmail($email) { 
    
        $this->email = $email;
    }

    public function getAddedOn() { 
    
        return $this->addedOn;
    }

    public function setAddedOn($addedOn) { 
    
        $this->addedOn = $addedOn;
    }

}

