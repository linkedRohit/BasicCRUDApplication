<?php
namespace Naukri\JobpostingBundle\Util\Exceptions;

use Naukri\JobpostingBundle\Util\Exceptions\JPExceptionHandler;
use Symfony\Component\Debug\ErrorHandler;

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of JPPhpErrorHandler
 *
 * @author Rajendra
 */
class JPPhpErrorHandler
{
    private static $enabled = false;

    /**
     * Enables the debug tools.
     *
     * This method registers an error handler and an exception handler.
     *
     * If the Symfony ClassLoader component is available, a special
     * class loader is also registered.
     *
     * @param integer $errorReportingLevel The level of error reporting you want
     * @param Boolean $displayErrors       Whether to display errors (for development) or just log them (for production)
     */
    public static function enable($errorReportingLevel = null, $displayErrors = true) { 
    
    
        if (static::$enabled) {
            return;
        }

        static::$enabled = true;

        error_reporting(-1);
        ErrorHandler::register($errorReportingLevel, $displayErrors);
        JPExceptionHandler::register(false);
    }
    
}

