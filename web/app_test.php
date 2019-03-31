<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

opcache_reset();
$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';
require __DIR__.'/../app/autoload.php';
//Debug::enable();

$kernel = new AppKernel('test', false);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
