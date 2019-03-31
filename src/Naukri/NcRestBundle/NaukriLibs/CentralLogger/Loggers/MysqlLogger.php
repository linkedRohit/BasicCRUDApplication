<?php
include_once(dirname(__FILE__).'/ILogger.php');

/**
 * MysqlLogger: This class uses the mysql pdo for logging the messages. It 
 * creates a connection to mysql database and send queries to that database  
 * 
 * @package 
 * @version 
 * @copyright 
 * @author Gaurav Asthana  <gaurav.asthana@gmail.com>
 * @license 
 */

class MysqlLogger implements ILogger {

    private $dbnode = null;

    private $opened = false;

    private $dbconnection = false;

    private $maxLogLevel = 6;

    private $showErrors = false;

    private $logSql = null;

    private $preparedStatement = null;

    public function __construct($conf = array()) {

        if (isset($conf['dbnode'])) {
            $this->dbnode = $conf['dbnode'];
        }
        if (isset($conf['maxLogLevel'])) {
            $this->maxLogLevel = $conf['maxLogLevel'];
        }
        if (isset($conf['showErrors'])) {
            $this->showErrors = $conf['showErrors'];
        }
        if (isset($conf['logSql'])) {
            $this->logSql = $conf['logSql'];
        }
    }

    private function open() {
        if (!$this->opened) {
            try {
                $this->dbconnection = ncDatabaseManager::getInstance()->getDatabase($this->dbnode)->getConnection();
                //$this->preparedStatement = $this->dbconnection->prepare($this->logSql);
                $this->opened = true;
            }
            catch(TException$e) {
                throw $e;
            }
            return $this->opened;
        }
    }

    public function doLog($formattedMessage, $rawMessage, $category, $level) {

        if (!$this->isAllowedLevel($level)) {
            return;
        }
        try {
            if (!$this->opened && !$this->open()) {
                return false;
            }
            $params = $rawMessage['params'];
            if (is_array($params) && count($params) > 0) {
                $this->preparedStatement = $this->dbconnection->prepare($this->logSql);
                //$res = $this->dbconnection->prepare($this->logSql);
                foreach ($params as $k => $param) {
                    if ($param['type'] == 'INT') {
                        $this->preparedStatement->bindValue($k, $param['val'], PDO::PARAM_INT);
                    } else {
                        $this->preparedStatement->bindValue($k, $param['val'], PDO::PARAM_STR);
                    }
                }
                $this->preparedStatement->execute();
                $this->preparedStatement->closeCursor();
            } elseif ($rawMessage['sql']) {
                $res = $this->dbconnection->query($rawMessage['sql']);
            }
        }
        catch(Exception$e) {
            if ($this->showErrors) {
                throw $e;
            }
        }
    }

    private function isAllowedLevel($level) {

        return($level <= $this->maxLogLevel) ? true : false;
    }
}
