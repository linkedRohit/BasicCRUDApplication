<?php
namespace Naukri\JobPostingGatewayBundle\Util\Logger;

use Exception;
use JMS\DiExtraBundle\Annotation as DI;
use Naukri\JobPostingGatewayBundle\Util\Common\CommonUtil;
use RuntimeException;

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of LogProcessor
 * to be used for pre-processing the logs
 * 
 * @author prabin
 */
/**
 * @DI\Service("jp.log.processor")
 * @DI\Tag("monolog.processor", attributes = {"method"="processLogRecord", "channel"="jp"})
 */
class LogProcessor
{
    /**
 * @DI\Inject("session") 
*/
    public $session;
    private $token;
    protected $ip;

    public function processLogRecord(array $record) { 
    
    
        if (null === $this->ip) {
            try {
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $this->ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $this->ip = $_SERVER['REMOTE_ADDR'];
                }
            } catch (RuntimeException $e) {
                $this->ip = '';
            }
        } 
        $cId = "";
        $rId = "";
        try {
            $tkn = $this->session->get('_security_jp_sso');
            if (!empty($tkn)) {
                $ssoToken = unserialize($tkn);
                $cId = $ssoToken->getUser()->getId();
                $rId = $ssoToken->getUser()->getCompanyId();
            }
        } catch (Exception $exc) {
            $this->ip = '';
        }
        $record['extra']['ip'] = $this->ip;
        if ("emergency" == CommonUtil::getArrayValueSafe($record, "channel", "")) {
            $context = CommonUtil::getArrayValueSafe($record, "context", array());
            $class = str_replace("/", "\\", $context['file']);
            $line = $context['line'];
        } else {
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 6);
            $class = $trace[5]['class'];
            $function = $trace[5]['function'];
            $line = $trace[4]['line'];
            if (strpos($class, "JPExceptionListener")) {
                $message = CommonUtil::getArrayValueSafe($record, "message");
                $parts = explode("|||", $message, 3);
                if (count($parts) > 2) {
                    $class = $parts[0];
                    $class = str_replace("/", "\\", $class);
                    $line = $parts[1];
                    $record["message"] = $parts[2];
                }
            }
        }
        $record['extra']['class'] = $class;
        $record['extra']['function'] = $function;
        $record['extra']['line'] = $line;
        $record['extra']['client'] = $cId;
        $record['extra']['user'] = $rId;
        $record['extra']['server'] = gethostname();
        $record['extra']['transactionId'] = $_SERVER['HTTP_X_TRANSACTION_ID'];
        return $record;
    }
}

