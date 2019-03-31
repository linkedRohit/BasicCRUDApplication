<?php
include_once(dirname(__FILE__).'/CentralLoggerException.php');
include_once(dirname(__FILE__).'/CentralLogger.php');

class CentralLoggerManager {

    private $loggersConfig;

    private static $instance;

    private $alertsConfig = array();

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->loggersConfig = array();
        $configs = sfYaml::load(CL_CONFIG.'/CentralLogger.yml');
        if (isset($configs['loggers'])) {
            $this->parseLoggersData($configs['loggers']);
        }
        if (isset($configs['alerts'])) {
            $this->alertsConfig = $configs['alerts'];
        }
    }

    private function parseLoggersData($configs = array()) {

        foreach ($configs as $logId => $logConfig) {
            $loggerType = $logConfig['loggerType'];
            $loggerParam = $logConfig['param'];
            $logger = array();
            if ($loggerType == 'mixed') {
                foreach ($loggerParam as $loggerId) {
                    if (!isset($configs[$loggerId])) {
                        throw new CentralLoggerException("Configs for '$loggerId' logger is not defined.");
                    }
                    $loggerIdType = $configs[$loggerId]['loggerType'];
                    $loggerIdParam = $configs[$loggerId]['param'];
                    $logger[$loggerIdType] = $loggerIdParam;
                }
            } else {
                $logger[$loggerType] = $loggerParam;
            }
            $this->loggersConfig[$logId] = $logger;
            //CentralLogger::getInstance($logger);
        }
        //print_r($this->loggersConfig);
    }

    public function getLogger($logId) {
        if (isset($this->loggersConfig[$logId])) {
            $cl = CentralLogger::getInstance($this->loggersConfig[$logId]);
            $cl->setAlertsConf($this->alertsConfig);
            include_once(dirname(__FILE__).'/LogFormatters/InfoLogFormatter.php');
            $logFormatter = new InfoLogFormatter();
            $cl->setLogFormatter($logFormatter);
            return $cl;
        }
        throw new CentralLoggerException("Configs for '$loggerId' logger is not defined.");
    }

    public function getErrorLogger($logId) {
        if (isset($this->loggersConfig[$logId])) {
            $cl = CentralLogger::getInstance($this->loggersConfig[$logId]);
            $cl->setAlertsConf($this->alertsConfig);
            include_once(dirname(__FILE__).'/LogFormatters/ErrorLogFormatter.php');
            $logFormatter = new ErrorLogFormatter();
            $cl->setLogFormatter($logFormatter);
            return $cl;
        }
        throw new CentralLoggerException("Configs for '$loggerId' logger is not defined.");
    }
}
