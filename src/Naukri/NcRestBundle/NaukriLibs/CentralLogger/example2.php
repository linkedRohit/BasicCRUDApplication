<?php
define('CL_CONFIG', './');
include('./CentralLoggerManager.php');
$l = CentralLoggerManager::getInstance()->getLogger('sampledb1');

$message['params'][':val1'] = array('val' => 'val1', 'type' => 'STR');
$message['params'][':val2'] = array('val' => 'val2', 'type' => 'STR');
$message['params'][':val3'] = array('val' => 123, 'type' => 'INT');
$l->log('Test', 'srv1:test:comp1', $message, 'dblog', 6);
