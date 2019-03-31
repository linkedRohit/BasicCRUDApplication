<?php
include_once(dirname(__FILE__).'/Loggers/ScribeLogger.php');
include_once(dirname(__FILE__).'/Loggers/ILogger.php');
//LOG_EMERG    0     /* System is unusable */
//LOG_ALERT    1     /* Immediate action required */
//LOG_CRIT     2     /* Critical conditions */
//LOG_ERR      3     /* Error conditions */
//LOG_WARNING  4     /* Warning conditions */
//LOG_NOTICE   5     /* Normal but significant */
//LOG_INFO     6     /* Informational */
//LOG_DEBUG    7     /* Debug-level messages */
/**
 * CentralLogger : This is a Central Logger Class. It provides functionality to 
 * add multiple loggers to add log message. By default it uses the scribe 
 * logger to log messages at a central location. 
 * 
 * @package 
 * @version 
 * @copyright 
 * @author Gaurav Asthana  <gaurav.asthana@gmail.com>
 * @license 
 */

class CentralLogger implements ILogger {

    private $configs = array();

    private $mobileNumbers = array();

    private $mailIds = array();

    private $alertsConf = array();

    private $logFormatter = null;

    private $loggers = array();

    private $maxLogLevel = 7;

    private static $instances;

    private function __construct($conf = array()) {
        $this->configs = $conf;
        //$this->logFormatter = $logFormatter;
        if (count($this->configs) > 0) {
            foreach ($this->configs as $logger => $loggerConfs) {
                try {
                    $loggerClass = ucfirst($logger).'Logger';
                    include_once(dirname(__FILE__).'/Loggers/'.$loggerClass.'.php');
                    $this->loggers[] = new $loggerClass($loggerConfs);
                }
                catch(Exception$e) {
                    $error = true;
                }
            }
            if (count($this->loggers) == 0) {
                $this->loggers[] = new ScribeLogger(array());
            }
        }
    }

    public static function getInstance($loggerConfigs = array()) {
        if (!isset(self::$instances)) {
            self::$instances = array();
        }
        $signature = serialize($loggerConfigs);
        if (!isset(self::$instances[$signature])) {
            self::$instances[$signature] = new CentralLogger($loggerConfigs);
        }
        return self::$instances[$signature];
    }

    public function log($appName, $appCode, $message, $errorType, $level = 4, $alertId = null) {
        if (!$this->isAllowedLevel($level)) {
            return;
        }
        /*if (!$this->logFormatter) {
            include_once(dirname(__FILE__).'/LogFormatter.php');
            $logFormatter = new LogFormatter();
        }*/
        $formattedMessage = $this->logFormatter->formatMessage($message, $appCode, $errorType, $level);
        if ($level == 1 || $level == 2 || $alertId) {
            $this->sendAlerts($formattedMessage, $alertId);
        }
        $this->doLog($formattedMessage, $message, $appName, $level);
    }

    public function doLog($formattedMessage, $rawMessage, $appName, $level) {
        foreach ($this->loggers as $logger) {
            $logger->doLog($formattedMessage, $rawMessage, $appName, $level);
        }
    }

    public function setMaxLogLevel($logLevel) {
        $this->maxLogLevel = $logLevel;
    }

    private function isAllowedLevel($level) {
        return($level <= $this->maxLogLevel) ? true : false;
    }

    private function sendAlerts($message, $alertId = "default") {
        if (!$alertId) {
            $alertId = "default";
        }
        if (isset($this->alertsConf[$alertId])) {
            $alertParams = $this->alertsConf[$alertId];
            if ($alertParams['enable']) {
                if (count($alertParams['emailIds']) > 0 && ($alertParams['alertType'] == 'both' || $alertParams['alertType'] == 'email')) {
                    AlertsSender::sendMailAlerts($alertParams['emailIds'], $message);
                }
                if (count($alertParams['mobiles']) > 0 && ($alertParams['alertType'] == 'both' || $alertParams['alertType'] == 'sms')) {
                    AlertsSender::sendSmsAlerts($alertParams['mobiles'], $message);
                }
            }
        }
    }

    public function setAlertsConf($alertsConf = array()) {
        $this->alertsConf = $alertsConf;
    }

    public function setLogFormatter($logFormatter = null) {
        $this->logFormatter = $logFormatter;
    }
}
