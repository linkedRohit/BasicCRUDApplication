<?php
namespace Naukri\JobPostingGatewayBundle\Resources\model\email;

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of EmailAddress
 *
 * @author Rajendra
 */
class EmailAddress
{
    private $email;
    private $name;
    
    public function __construct($email, $name='') { 
    
        $this->email = $email;
        $this->name = $name;
    }
    
    public function getEmail() { 
    
        return $this->email;
    }

    public function getName() { 
    
        if (!empty($this->name)) {
            return $this->name;
        }
        return $this->email;
    }
    
    public function getAsSwiftEmailFormatArray() { 
    
        return array($this->getEmail()=> $this->getName());
    }
    
    public function setEmail($email) { 
    
        $this->email = $email;
    }

    public function setName($name) { 
    
        $this->name = $name;
    }



}

