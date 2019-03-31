<?php
include_once(dirname(__FILE__).'/ILogger.php');

/**
 * FileLogger: This class uses the files for logging the messages. 
 * 
 * @package 
 * @version 
 * @copyright 
 * @author Gaurav Asthana  <gaurav.asthana@gmail.com>
 * @license 
 */

class FileLogger implements ILogger
{

    protected $filename = null;

    private $tracefile = null;

    private $filemode = 0644;

    protected $messages = array();

    private $fileHandle;

    protected $logInBatch = false;

    protected $logBatchSize = 0;

    private $opened = false;

    private $maxLogLevel = 7;

    protected $showErrors = false;

    public function __construct($conf = array()) {
        if (isset($conf['filename'])) {
            $this->filename = $conf['filename'];
        }
        if (isset($conf['filemode'])) {
            $this->filemode = $conf['filemode'];
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
            register_shutdown_function(array(&$this, '_FileLogger'));
        }
        if (isset($conf['tracefile'])) {
            include_once(dirname(__FILE__).'/TraceFileLogger.php');
            $this->tracefile = new TraceFileLogger($conf);
        }
    }

    private function open() {

        if (!$this->opened) {
            try {
                $logFileName = $this->generateFileName($this->filename);

                /** 
                 * If the log file's directory doesn't exist, create it.
                 */

                if (!is_dir(dirname($logFileName))) {
                    $this->mkpath($logFileName, 0755);
                }
                $this->fileHandle = fopen($logFileName, "a+");
                $this->opened = ($this->fileHandle !== false);
                //if ($this->opened) {
                  //  chmod($logFileName, $this->filemode);
                //}
            }
            catch(TException$e) {
                throw $e;
            }
            return $this->opened;
        }
    }

    private function generateFileName($filename){
        $pattern = "/\%([^\%]*)\%/";
        preg_match_all($pattern, $filename, $matches);
        if(count($matches) > 0)
        {
            foreach($matches[1] as $match)
            {
                $date = date($match);
                $filename = preg_replace("/\%".$match."\%/", $date, $filename);
            }
        }
        return $filename;
    }


    private function mkpath($path, $mode = 0755) {

        /** 
         * Separate the last pathname component from the rest of the path. 
         */

        $head = dirname($path);
        $tail = basename($path);

        /** 
         * Make sure we've split the path into two complete components. 
         */

        if (empty($tail)) {
            $head = dirname($path);
            $tail = basename($path);
        }

        /** 
         * Recurse up the path if our current segment does not exist. 
         */

        if (!empty($head) && !empty($tail) && !is_dir($head)) {
            $this->mkpath($head, $mode);
        }

        /** 
         * Create this segment of the path.
         */

        return @mkdir($head, $mode);
    }

    public function _FileLogger() {

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
            fclose($this->fileHandle);
        }
        return true;
    }

    protected function flush() {

        if (count($this->messages) > 0) {
            try {
                if (!$this->opened && !$this->open()) {
                    return false;
                }
                foreach ($this->messages as $msg) {
                    fputs($this->fileHandle, $msg);
                }
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
        if($this->filename){
        $this->messages[] = $formattedMessage;
        if (!$this->logInBatch || (($this->logBatchSize > 0) && (count($this->messages) == $this->logBatchSize))) {
            try {
                $this->flush();
            }
            catch(Exception$e) {
                if ($this->showErrors) {
                    throw $e;
                }
            }
        }}
        if($this->tracefile){
            $this->tracefile->doLog($formattedMessage, $rawMessage, $category, $level);
        }
    }

    protected function isAllowedLevel($level) {
        return($level <= $this->maxLogLevel) ? true : false;
    }
}
