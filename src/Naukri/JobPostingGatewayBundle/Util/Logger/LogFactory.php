<?php
namespace Naukri\JobPostingGatewayBundle\Util\Logger;

use Symfony\Component\DependencyInjection\ContainerAware;

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of LogFactory
 * DO NOT USE: An experimental class
 *
 * @author prabin
 */
class LogFactory extends ContainerAware
{
    private static $instance;
    private $logger;
    
    private function __construct() { 
    
        self::$instance = null;
    }
    
    public static function getInstance() { 
    
        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class();
        }

        return self::$instance;
    }
    
    public function getLogger() { 
    
    
        $this->container->get('jp.logger')->getLogger();
    }
}

