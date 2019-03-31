<?php
/**
 * FileLogger: This class uses the files for logging the messages. 
 * 
 * @package 
 * @version 
 * @copyright 
 * @author Gaurav Asthana  <gaurav.asthana@gmail.com>
 * @license 
 */

class TraceFileLogger extends FileLogger {

    public function __construct($conf = array()) {

        $conf['filename'] = $conf['tracefile'];
        unset($conf['tracefile']);
        parent::__construct($conf);
    }

    public function doLog($formattedMessage, $rawMessage, $category, $level) {

        if (!$this->isAllowedLevel($level)) {
            return;
        }
        if ($this->filename) {
            $this->messages[] = $this->getTrace($formattedMessage, $rawMessage);
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
    }

    private function getTrace($message, $rawMessage) {

        $trace[] = trim($message, "\n");
        if (method_exists($rawMessage, 'getTrace')) {
            $bt = $this->getStackTrace($rawMessage);
        } else {
            $dbt = debug_backtrace();
            for ($i = 2; $i < count($dbt); $i++) {
                $bt[] = "#$i ".$dbt[$i]['class']."->".$dbt[$i]['function']." in ".$dbt[$i]['file']." line ".$dbt[$i]['line'];
                //     $bt[] = "#$i ".$dbt[$i]['file']."(".$dbt[$i]['line']."): ".$dbt[$i]['class']."->".$dbt[$i]['function'];
            }
        }
        $trace[] = implode("\n", $bt);
        $trace[] = "\$_GET:".json_encode($_GET);
        $trace[] = "\$_POST:".json_encode($_POST);
        $trace[] = "\$_COOKIE:".json_encode($_COOKIE);
        $trace[] = "REQUEST_HEADERS:".json_encode((function_exists("apache_request_headers") ? apache_request_headers() : array()));
        $trace[] = "\$_FILES:".json_encode($_FILES);
        $trace[] = "\$_SERVER:".json_encode($_SERVER);
        return implode("\n", $trace)."\n\n";
    }

    private function getStackTrace($exception) {

        $traceData = $exception->getTrace();
        array_unshift($traceData, array('function' => '', 'file' => $exception->getFile() != null ? $exception->getFile() : null, 'line' => $exception->getLine() != null ? $exception->getLine() : null, 'args' => array(),));
        $traces = array();
        $lineFormat = '%s %s%s%s in %s line %s';
        for ($i = 0, $count = count($traceData); $i < $count; $i++) {
            $line = isset($traceData[$i]['line']) ? $traceData[$i]['line'] : null;
            $file = isset($traceData[$i]['file']) ? $traceData[$i]['file'] : null;
            //$args = isset($traceData[$i]['args']) ? $traceData[$i]['args'] : array();
            $traces[] = sprintf($lineFormat, '#'.$i, $traceData[$i]['class'], $traceData[$i]['type'], $traceData[$i]['function'], $traceData[$i]['file'], $traceData[$i]['line']);
        }
        return $traces;
    }
}
