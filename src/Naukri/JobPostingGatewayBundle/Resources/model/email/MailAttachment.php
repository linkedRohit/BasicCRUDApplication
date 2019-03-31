<?php
namespace Naukri\JobPostingGatewayBundle\Resources\model\email;

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of MailAttachment
 *
 * @author Rajendra
 */
class MailAttachment
{
    private $data;
    private $fileName;
    private $contentType;
    
    public function __construct($data, $fileName=null, $contentType=null) { 
    
        $this->data = $data;
        $this->fileName = $fileName;
        $this->contentType = $contentType;
    }
    
    public function getData() { 
    
        return $this->data;
    }

    public function getFileName() { 
    
        return $this->fileName;
    }

    public function getContentType() { 
    
        return $this->contentType;
    }
}

