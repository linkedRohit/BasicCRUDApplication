<?php
/**
 * ErrorLogFormatter: This class is for formatting the log message to be sent to the 
 * loggers. It provides a fixed format message, but additional text can be 
 * attached to those messages by providing the log appenders. Any number of log 
 * appenders can be passed. These appenders will be executed in the order they 
 * are provided to the class.
 * 
 * @package 
 * @version 
 * @copyright 
 * @author Gaurav Asthana 
 * @license 
 */
include_once(dirname(__FILE__).'/LogFormatter.php');
final class InfoLogFormatter extends LogFormatter
{

    public function __construct($logAppenders = array()) {

        parent::__construct($logAppenders);
    }

    protected function format($message, $appCode, $errorType, $level) {
        //$msg[] = trim(shell_exec('hostname'));
        if(!isset($_SERVER['SERVER_NAME'])) {
            $msg[] = gethostname();   
        } else {
            $msg[] = trim($_SERVER['SERVER_NAME']);
        }
        $msg[] = date('Y-m-d H:i:s');//strftime('%b %d %H:%M:%S');
        $msg[] = $appCode;
        $msg[] = $this->levelToString($level);
        $msg[] = $errorType;
        $msg[] = '['.str_replace('\n', '\r', $message).']';
        return implode($this->msgDelimiter, $msg);
    }

}