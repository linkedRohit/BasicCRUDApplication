<?php
namespace Naukri\JobPostingGatewayBundle\Dao\ncPDO;

use Exception;
use ncDatabaseException;
use ncDatabaseManager;
use PDO;

/**
 * Description of DBConnectionFactoryNcPDO
 *
 * @author Rohit Sharma
 */

class DBConnectionFactoryNcPDO
{
    private static $instance;
    private $dbConnections;

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

    public function getDBConnectionForServerTag($serverTag) { 
        return ncDatabaseManager::getInstance()->getDatabase($serverTag)->getConnection();
    }

    public function getAccountsDBConnection() { 
        return ncDatabaseManager::getInstance()->getDatabase("accounts")->getConnection();
    }

}
