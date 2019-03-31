<?php
namespace Naukri\JobPostingGatewayBundle\Util\Logger;

use CentralLoggerManager;
use Exception;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Bridge\Monolog\Logger;

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of JPLogger
 *
 * @author prabin
 */
/**
 * @DI\Service("jp.logger")
 * @DI\Tag("monolog.logger", attributes = {"channel"="jp"})
 */
class JPLogger
{
    private $logger;
    
    /**
     * this has to be in constructor else channelling won't work
     *
     * @DI\InjectParams({ "logger" = @DI\Inject("logger") })
     */
    public function __construct(Logger $logger) { 
    
        $this->logger = $logger;
    }

    public function getLogger() { 
    
    
        return $this->logger;
    }

    private function appendMessage($message) { 
    
        if (isset($_SERVER['HTTP_X_TRANSACTION_ID'])) {
            $message .= ' Transaction_id -> ' . $_SERVER['HTTP_X_TRANSACTION_ID'];
        }
        return $message;
    }

    public function debug($message) { 
    
        $message = $this->appendMessage($message);
        $this->logger->debug($message);
        $l = CentralLoggerManager::getInstance()->getErrorLogger('default');
        //$l->log('JPGeneral', 'sm.debug', $message, 'debug', 4);
    }

    public function info($message) { 
    
        $message = $this->appendMessage($message);
        $this->logger->info($message);
    }

    public function notice($message) { 
    
        $message = $this->appendMessage($message);
        $this->logger->notice($message);
    }
    
    public function warn($message, Exception $e=null) { 
    
        $message = $this->appendMessage($message);
        $this->logger->warning($message." ".(is_null($e)?"":$e->getMessage().":  ".$e->getTraceAsString()));
        $l = CentralLoggerManager::getInstance()->getErrorLogger('default');
        //$l->log('JPGeneral', 'sm.warn', $message, 'warning', 4);
    }

    public function err($message, Exception $e=null) { 
    
        $message = $this->appendMessage($message);
        $this->logger->error($message." ".(is_null($e)?"":$e->getMessage().":  ".$e->getTraceAsString()));
        $l = CentralLoggerManager::getInstance()->getErrorLogger('default');
        //$l->log('JPGeneral', 'sm.error', $message, 'error', 3, 'erroralerts');
    }

    public function crit($message, Exception $e=null) { 
    
        $message = $this->appendMessage($message);
        $this->logger->critical($message." ".(is_null($e)?"":$e->getMessage().":  ".$e->getTraceAsString()));
        $l = CentralLoggerManager::getInstance()->getErrorLogger('default');
        //$l->log('JPGeneral', 'sm.critical', $message, 'critical', 2, 'fatalalerts');
    }

    public function alert($message, Exception $e=null) { 
    
        $message = $this->appendMessage($message);
        $this->logger->alert($message." ".(is_null($e)?"":$e->getMessage().":  ".$e->getTraceAsString()));
    }
    
    
}

