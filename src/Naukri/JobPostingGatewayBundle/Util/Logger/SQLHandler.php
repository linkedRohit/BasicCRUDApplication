<?php
namespace Naukri\JobPostingGatewayBundle\Util\Logger;

use Exception;
use JMS\DiExtraBundle\Annotation as DI;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Naukri\JobPostingGatewayBundle\Resources\model\email\Email;
use Naukri\JobPostingGatewayBundle\Resources\model\email\EmailAddress;
use Naukri\JobPostingGatewayBundle\Util\Common\CommonUtil;

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of SQLHandler
 * Class to be used to put logs in DB
 *
 * @author prabin
 */
/**
 * @DI\Service("jp.sql.log.handler")
 */
class SQLHandler extends AbstractProcessingHandler
{

    /*
 * @DI\Inject("logger.dao")

    public $loggerDao;

    /**
 * @DI\Inject("jp.zend.mailer")
*/
    public $jpMailer;

    private $config;

    /**
     * @DI\InjectParams({ "config" = @DI\Inject("%custom.log.handler%") })
     */
    public function __construct($config) { 
    

        $this->config = $config;
        $level = Logger::ERROR;
        $logLevel = CommonUtil::getArrayValueSafe($config, 'level', 'error');
        if ("info" == strtolower($logLevel)) {
            $level = Logger::INFO;
        } elseif ("warn" == strtolower($logLevel)) {
            $level = Logger::WARNING;
        } elseif ("crit" == strtolower($logLevel)) {
            $level = Logger::CRITICAL;
        } elseif ("error" == strtolower($logLevel)) {
            $level = Logger::ERROR;
        } elseif ("alert" == strtolower($logLevel)) {
            $level = Logger::ALERT;
        }
        parent::__construct($level);
    }

    protected function write(array $record) { 
    
        try{
            /*
            //commented as we do not want online email. errors will sent as batch from db
            $email = CommonUtil::getArrayValueSafe($this->config, 'email', '');
            if (!empty($email)) {
            $this->sendLogMail($email, $record);
            }
            */
            //$this->loggerDao->logToDB($record);

        }
        catch (Exception $e) {
            return false;
        }
    }

    private function sendLogMail($toEmail, $record) { 
    
        try{
            $subject="Awesomeness in JP server: ".gethostname();
            $fromEmail = gethostname()."@naukri.com";
            $from = new EmailAddress($fromEmail, "JP error");
            $to = array();
            $emails = explode(",", $toEmail);
            foreach ($emails as $email) {
                $to[] = new EmailAddress($email);
            }
            $body = $record['formatted'];//var_export($record, true);
            $body = str_replace("#", "<br>#", $body);
            $emailObj = new Email();
            $emailObj->setSubject($subject);
            $emailObj->setTo($to);
            $emailObj->setFrom($from);
            $emailObj->setBody($body);
            //$this->jpMailer->send($emailObj);
        }catch (Exception $e) {
            return false;
        }
    }
}
