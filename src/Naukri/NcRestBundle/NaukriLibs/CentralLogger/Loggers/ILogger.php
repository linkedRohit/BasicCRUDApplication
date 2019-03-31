<?php
/**
 * ILogger Interface for different types of Loggers
 * 
 * @package 
 * @version 
 * @copyright 
 * @author Gaurav Asthana 
 * @license 
 */
interface ILogger
{

    public function doLog($formattedMessage, $rawMessage, $appName, $level);
}
