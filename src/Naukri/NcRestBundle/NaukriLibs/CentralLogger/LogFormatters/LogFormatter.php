<?php
/**
 * LogFormatter: This class is for formatting the log message to be sent to the 
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
abstract class LogFormatter
{

    private $logAppenders = array();

    protected $msgDelimiter = ' - ';

    protected $rawMessage;

    public function __construct($logAppenders = array()) {

        foreach ($logAppenders as $logAppender) {
            if ($logAppender instanceof ILogAppender) {
                $this->logAppenders[] = $logAppender;
            }
        }
    }

    public function formatMessage($message, $appCode, $errorType, $level) {
        $this->rawMessage = $message;
        $message = $this->extractMessage($message);
        $message = $this->format($message, $appCode, $errorType, $level);
        foreach ($this->logAppenders as $logAppender) {
            $message .= $this->msgDelimiter.$logAppender->getMessage();
        }
        $message .= "\n";
        return $message;
    }

    abstract protected function format($message, $appCode, $errorType, $level);

    protected function extractMessage($message) {
        if (is_object($message)) {
            if (method_exists($message, 'getmessage')) {
                $message = $message->getMessage();
            } elseif (method_exists($message, 'tostring')) {
                $message = $message->toString();
            } elseif (method_exists($message, '__tostring')) {
                $message = (string) $message;
            } else {
                $message = var_export($message, true);
            }
        } elseif (is_array($message)) {
            if (isset($message['message'])) {
                if (is_scalar($message['message'])) {
                    $message = $message['message'];
                } else {
                    $message = var_export($message['message'], true);
                }
            } else {
                $message = var_export($message, true);
            }
        } elseif (is_bool($message) || $message === NULL) {
            $message = var_export($message, true);
        }

        /** 
         * Otherwise, we assume the message is a string.
         */

        return $message;
    }

    protected function getBacktraceVars() {
        if (method_exists($this->rawMessage, 'getTrace')) {
            return $this->getStackTraceVars($this->rawMessage);
        }
        else{
            return $this->getDebugBackTraceVars(5);
        }
    }

    private function getStackTraceVars($message){
        $traceData = $message->getTrace();
        $file = $traceData[0]['file'];
        $line = $traceData[0]['line'];
        $func = $traceData[0]['function'];
        $class = $traceData[0]['class'];
        return array($file, $line, $func, $class);
    }

    private function getDebugBackTraceVars($depth){

        /** 
         * Start by generating a backtrace from the current call (here). 
         */

        $bt = debug_backtrace();

        /** 
         * Store some handy shortcuts to our previous frames. 
         */

        $bt0 = isset($bt[$depth]) ? $bt[$depth] : null;
        $bt1 = isset($bt[$depth + 1]) ? $bt[$depth + 1] : null;

        /**
         * If we were ultimately invoked by the composite handler, we need to
         * increase our depth one additional level to compensate.
         */

        $class = isset($bt1['class']) ? $bt1['class'] : null;
        if ($class !== null && strcasecmp($class, 'Log_composite') == 0) {
            $depth++;
            $bt0 = isset($bt[$depth]) ? $bt[$depth] : null;
            $bt1 = isset($bt[$depth + 1]) ? $bt[$depth + 1] : null;
            $class = isset($bt1['class']) ? $bt1['class'] : null;
        }

        /**
         * We're interested in the frame which invoked the log() function, so
         * we need to walk back some number of frames into the backtrace.  The
         * $depth parameter tells us where to start looking.   We go one step
         * further back to find the name of the encapsulating function from
         * which log() was called.
         */

        $file = isset($bt0) ? $bt0['file'] : null;
        $line = isset($bt0) ? $bt0['line'] : 0;
        $func = isset($bt1) ? $bt1['function'] : null;

        /**
         * However, if log() was called from one of our "shortcut" functions,
         * we're going to need to go back an additional step.
         */

        if (in_array($func, array('emerg', 'alert', 'crit', 'err', 'warning', 'notice', 'info', 'debug'))) {
            $bt2 = isset($bt[$depth + 2]) ? $bt[$depth + 2] : null;
            $file = is_array($bt1) ? $bt1['file'] : null;
            $line = is_array($bt1) ? $bt1['line'] : 0;
            $func = is_array($bt2) ? $bt2['function'] : null;
            $class = isset($bt2['class']) ? $bt2['class'] : null;
        }

        /**
         * If we couldn't extract a function name (perhaps because we were
         * executed from the "main" context), provide a default value.
         */

        if ($func === null) {
            $func = '(none)';
        }

        /** 
         * Return a 4-tuple containing (file, line, function, class). 
         */

        return array($file, $line, $func, $class);
    }

    protected function levelToString($priority) {
        $levels = array(
                            0 => 'emergency', 
                            1 => 'alert', 
                            2 => 'critical', 
                            3 => 'error', 
                            4 => 'warning', 
                            5 => 'notice', 
                            6 => 'info', 
                            7 => 'debug'
                  );
        return $levels[$priority];
    }
}
