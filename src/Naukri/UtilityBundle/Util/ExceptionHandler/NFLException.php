<?php
namespace Naukri\UtilityBundle\Util\ExceptionHandler;

use Exception;

/**
 * Description of JPException
 *
 * @author Rohit Sharma
 */
class NFLException extends Exception
{
    /**
    * Common section, server, db, mail issue (1-99)
    */
    const E_TYPE_DATAINTEGRITYVOILATION=1;
    const E_TYPE_DATANOTFOUNDEXCEPTION=2;
    const E_TYPE_UNAUTHORIZEDEXCEPTION=3;
    const E_TYPE_SQLEXCEPTION=4;
    const E_TYPE_INVALIDOPERATIONEXCEPTION=5;
    const E_TYPE_DBDOWNEXCEPTION=6;
    const E_TYPE_SERVERBUSY=7;
    const E_TYPE_INVALIDDATATYPE=8;
    const E_TYPE_SERVERERROR=9;
    const E_TYPE_UNSUPPORTEDWEBMAIL=10;
    const E_TYPE_IOEXCEPTION=11;
    const E_TYPE_HTTPEXCEPTION=12;
    const E_TYPE_UNEXPECTEDFORMAT=13;
    const E_TYPE_MAIL_NOT_SENT = 14;
    const E_TYPE_NO_SUFFICENT_PRIVILAGES=15;
    const E_TYPE_ILLEGALARGUMENT=16;
    const E_TYPE_ILLEGAL_STATE_EXCEPTION=17;
    const E_TYPE_NOT_ELLIGIBELE=18;
    const E_TYPE_UNEXPECTEDEXCEPTION=19;
    const E_TYPE_INVALID_STATE=20;
    const E_TYPE_UNSUPPORTED_FUNCTIONALITY=21;
    const E_TYPE_PHOTO_COULDNOT_RESIZE=22;
    const E_TYPE_MUST_LOGIN = 23;
    const E_TYPE_AUTHOR_CANNOT_RATE = 24;
    const E_TYPE_INVALID_JSONSTRING = 25;
    const E_TYPE_INVALID_NUMBER_FORMAT = 26;
    const E_TYPE_INVALID_ADDITIONAL_COLUMN = 27;
    const E_TYPE_ONLY_NUMBER_ALLOWED = 28;
    const E_TYPE_SPECIAL_CHARACTER_ALLOWED = 29;
    const E_TYPE_UNKNOWN_ERROR = 1000;

    //constants 9000 to 9999  for AUTHENTICATION
    const E_TYPE_NO_SUBSCRIPTION = 9000;
    const E_TYPE_EXPIRED_SUBSCRIPTION = 9001;
    const E_TYPE_USER_NORIGHTS = 9002;
    const E_TYPE_UNAUTHORISED_ACCESS = 9003;
    const E_TYPE_RECRUITER_DOESNOTEXIST = 9003;
    const E_TYPE_CLIENT_DOESNOTEXIST = 9003;


    public function __construct ($message = null, $code = null) {
        if (empty($message)) {
            if (!isset($code)) {
                $message = NFLMessages::getMessage($code);
            }
        }
        parent::__construct($message, $code);
    }
    
    

    private static function errorMail() {
        $objMailer = new mailler2();
        $objMailer->initialize('Naukri.com','errors@naukriposting.com','arpit.jain@naukri.com','jobposting exceptions',$message,'','','','errors@naukriposting.com');
        $objMailer->sendMail();
    }


}
