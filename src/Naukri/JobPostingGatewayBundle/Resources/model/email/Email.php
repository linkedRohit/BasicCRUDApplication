<?php
namespace Naukri\JobPostingGatewayBundle\Resources\model\email;

use Naukri\JobPostingGatewayBundle\Resources\model\BaseModel;
use Naukri\JobPostingGatewayBundle\Resources\model\email\EmailAddress;
 
/**
 * Naukri\JobPostingGatewayBundle\Resources\model\email\Email
 *
 * @author Rajendra
 */

class Email extends BaseModel
{

    /**
 * @var EmailAddress
*/
    private $from;
    
    /**
 * @var array of EmailAddress
*/
    private $to;
    
    /**
 * @var array of EmailAddress
*/
    private $bcc;
    
    /**
 * @var array of EmailAddress
*/
    private $cc;
    
    /**
 * @var string 
*/
    private $subject;
    
    /**
 * @var string 
*/
    private $body;
    
    /**
 * @var array of MailAttachment
*/
    private $attachmentList;
    
    /**
 * @var EmailAddress
*/
    private $replyto;
    
    private $clientId;
    
    public function getClientId() { 
    
        return $this->clientId;
    }

    public function setClientId($clientId) { 
    
        $this->clientId = $clientId;
    }
    
    public function getFrom() { 
    
        return $this->from;
    }

    public function setFrom(EmailAddress $from) { 
    
        
        $posAt = strpos($from->getEmail(), '@');
        
        $fromEmail = $from->getEmail();
        $domain = substr($fromEmail, $posAt+1);
        $client = substr($fromEmail, 0, $posAt);
        $company = substr($domain, 0, strpos($domain, '.'));
        if ($domain == JPDOMAIN ) {
            $this->replyto = new EmailAddress('no-reply@'.JPDOMAIN, 'No Reply');      
            $this->from = $from;
        } else {
            $this->replyto = $from;
            $this->from = new EmailAddress($client.'.'.$company.'@'.JPDOMAIN, $from->getName());
        }
        
    }

    public function getTo() { 
    
        return $this->to;
    }

    public function setTo($to) { 
    
        $this->to = $to;
    }

    public function getBcc() { 
    
        return $this->bcc;
    }

    public function setBcc($bcc) { 
    
        $this->bcc = $bcc;
    }

    public function getCc() { 
    
        return $this->cc;
    }

    public function setCc($cc) { 
    
        $this->cc = $cc;
    }

    public function getSubject() { 
    
        return $this->subject;
    }

    public function setSubject($subject) { 
    
        $this->subject = $subject;
    }

    public function getBody() { 
    
        return $this->body;
    }

    public function setBody($body) { 
    
        $this->body = $body;
    }

    public function getAttachmentList() { 
    
        return $this->attachmentList;
    }

    public function setAttachmentList($attachmentList) { 
    
        $this->attachmentList = $attachmentList;
    }

    public function getReplyto() { 
    
        return $this->replyto;
    }

    public function setReplyto($replyto) { 
    
        $this->replyto = $replyto;
    }
    
}
