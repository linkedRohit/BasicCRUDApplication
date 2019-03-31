<?php

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read https://symfony.com/doc/current/setup.html#checking-symfony-application-configuration-and-setup
// for more information
//umask(0000);

require __DIR__.'/../app/autoload.php';
error_reporting(0);
//ini_set('display_errors',1);
//Debug::enable();
$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
//Debug::enable(error_reporting() );
// enable the line below to see warnings & notices as exceptions
//Debug::enable();
//ini_set("error_reporting", E_ERROR);
require_once __DIR__.'/../app/AppClusterKernel.php';

$kernel = new AppClusterKernel('cluster', false);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
