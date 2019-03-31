<?php
namespace Naukri\JobPostingGatewayBundle\Util\Logger;

use CentralLoggerManager;
use Exception;
use JMS\DiExtraBundle\Annotation as DI;

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of JPCentralLogger
 *
 * @author srikanth
 */
/**
 * @DI\Service("jpcentral.logger")
 */
class JPCentralLogger
{
    private $logger;
    
    public function __construct() { 
    
        $this->logger = CentralLoggerManager::getInstance()->getErrorLogger('default');
        $this->logger->setLogFormatter();
    }
    /*    
    public function log($message,$filename='') {
        
    //do logging functionality
    }


    public function getLogger($type) {
    $this->logger = parent::getInstance()->getLogger($type);
    $this->setCustomLogger('CustomLogFormatter');
    return $this->logger;
       
    }
    
    public static function getFileLogger($type) {
    $this->logger = parent::getInstance()->getLogger($type);
    $this->setCustomLogger('FileLogFormatter');
    return $this->logger;
       
    }
    
    public function setCustomLogger($formater) {
    $class = $formater;
    $this->logger->setLogFormatter(new $class());

    }    */
}
