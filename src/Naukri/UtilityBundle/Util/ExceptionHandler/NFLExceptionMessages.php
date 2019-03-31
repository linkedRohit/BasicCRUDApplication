<?php

namespace Naukri\UtilityBundle\Util\ExceptionHandler;

use MessageFormatter;
use Naukri\JobPostingGatewayBundle\Util\Exceptions\NFLException;

/**
 * @author Rohit Sharma
 */
class NFLMessages
{
    
    const APPLICATION_NOT_EXIST = "Application does not exit";
    const CANDIDATE_NOT_EXIST = "Candidate does not exit";
    const PROJECT_NOT_EXIST = "Requirement does not exit";
    private static $messages = array('en_US' => array(
            NFLException::E_TYPE_UNKNOWN_ERROR=> 'An unknown error has occured.',
            NFLException::E_TYPE_CLIENT_DOESNOTEXIST=>'Client does not exist',
            NFLException::E_TYPE_RECRUITER_DOESNOTEXIST=>'Recruiter does not exist',
            NFLException::E_TYPE_INVALID_JSONSTRING=>'Invalid JSON String.',
            NFLException::E_TYPE_NO_SUBSCRIPTION=>'subscription error'
        )
    );

    public static function getMessage($code, $args = array(), $locale = 'en_US') {
        if (array_key_exists($code, self::$messages[$locale])) {
            return MessageFormatter::formatMessage($locale, self::$messages[$locale][$code], $args);
        } else {
            return 'Error Occurred';
        }
    }

}

