<?php
include_once(dirname(__FILE__).'/ILogger.php');

//if (!class_exists('TException')) {
//$GLOBALS['THRIFT_ROOT'] = dirname(__FILE__).'/../scribephplibs';
require_once dirname(__FILE__).'/../packages/scribe/scribe.php';
//require_once dirname(__FILE__).'/../packages/scribe/scribe_types.php';
//require_once $GLOBALS['THRIFT_ROOT'].'/transport/TSocket.php';
//require_once $GLOBALS['THRIFT_ROOT'].'/transport/TFramedTransport.php';
//require_once $GLOBALS['THRIFT_ROOT'].'/protocol/TBinaryProtocol.php';
//}

/**
 * ScribeLogger: This class uses the scribe for logging the messages. It 
 * creates a connection to scribe clients and send message to that client 
 * asynchronously.  
 * 
 * @package 
 * @version 
 * @copyright 
 * @author Gaurav Asthana  <gaurav.asthana@gmail.com>
 * @license 
 */

class ScribeLogger implements ILogger
{

    private $socket = null;

    private $ip = '127.0.0.1';

    private $port = 1463;

    private $sendTimeout = 100;

    private $recvTimeout = 750;

    private $transport = null;

    private $scribeClient = null;

    private $messages = array();

    private $logInBatch = false;

    private $logBatchSize = 0;

    private $opened = false;

    private $maxLogLevel = 4;

    private $showErrors = false;

    public function __construct($conf = array()) {

        if (isset($conf['ip'])) {
            $this->ip = $conf['ip'];
        }
        if (isset($conf['port'])) {
            $this->port = $conf['port'];
        }
        if (isset($conf['sendTimeout'])) {
            $this->sendTimeout = $conf['sendTimeout'];
        }
        if (isset($conf['recvTimeout'])) {
            $this->recvTimeout = $conf['recvTimeout'];
        }
        if (isset($conf['logInBatch'])) {
            $this->logInBatch = $conf['logInBatch'];
        }
        if (isset($conf['logBatchSize'])) {
            $this->logBatchSize = $conf['logBatchSize'];
        }
        if (isset($conf['maxLogLevel'])) {
            $this->maxLogLevel = $conf['maxLogLevel'];
        }
        if (isset($conf['showErrors'])) {
            $this->showErrors = $conf['showErrors'];
        }
        if ($this->logInBatch) {
            register_shutdown_function(array(&$this, '_ScribeLogger'));
        }
    }

    private function open() {
        if (!$this->opened) {
            try {
                $this->socket = new TSocket($this->ip, $this->port, false);
                $this->socket->setSendTimeout($this->sendTimeout);
                $this->socket->setRecvTimeout($this->recvTimeout);
                $this->transport = new TFramedTransport($this->socket);
                $protocol = new TBinaryProtocol($this->transport, false, false);
                $this->scribeClient = new scribeClient($protocol, $protocol);
                $this->opened = true;
            }
            catch(TException$e) {
                throw $e;
            }
            return $this->opened;
        }
    }

    public function _ScribeLogger() {
        try {
            $this->flush();
        }
        catch(Exception$e) {
            if ($this->showErrors) {
                throw $e;
            }
        }
        if ($this->opened) {
            $this->opened = false;
            return $this->socket->close();
        }
        return true;
    }

    private function flush() {
        if (count($this->messages) > 0) {
            try {
                if (!$this->opened && !$this->open()) {
                    return false;
                }
                $this->transport->open();
                $this->scribeClient->Log($this->messages);
                $this->transport->close();
                $this->messages = array();
            }
            catch(Exception$e) {
                throw $e;
            }
        }
        return true;
    }

    public function doLog($formattedMessage, $rawMessage, $category, $level) {

        if (!$this->isAllowedLevel($level)) {
            return;
        }
        $msg = array();
        $msg['category'] = $category;
        $msg['message'] = $formattedMessage;
        $entry = new LogEntry($msg);
        $this->messages[] = $entry;
        if (!$this->logInBatch || (($this->logBatchSize > 0) && (count($this->messages) == $this->logBatchSize))) {
            try {
                $this->flush();
            }
            catch(Exception$e) {
                if ($this->showErrors) {
                    throw $e;
                }
            }
        }
    }

    private function isAllowedLevel($level) {

        return($level <= $this->maxLogLevel) ? true : false;
    }
}
