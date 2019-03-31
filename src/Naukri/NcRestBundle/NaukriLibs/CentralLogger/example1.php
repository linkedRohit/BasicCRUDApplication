<?php

define('CL_CONFIG', './');
include('./CentralLoggerManager.php');

//To log erros

$l = CentralLoggerManager::getInstance()->getErrorLogger('samplefile');
$l->log('Test', 'srv1:test:comp1', 'testing central logger', 'general', 4, 'default');


//To log other data

$l = CentralLoggerManager::getInstance()->getLogger('samplefile');
$l->log('Test', 'srv1:test:comp1', 'storing data', 'benchmarks', 6);


//print_r($l);
