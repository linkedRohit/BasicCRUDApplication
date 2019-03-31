<?php
/**
 * ILogAppender : Interface for Log message appenders to be passed to Log 
 * formatters 
 * 
 * @package 
 * @version 
 * @copyright 
 * @author Gaurav Asthana 
 * @license 
 */
interface ILogAppender
{

    public function getMessage();
}
