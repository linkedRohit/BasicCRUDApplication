<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

$path = "/home/madhur/htdocs/rest/";
$ymlPath = $path."config/rest.yml";

define("NC_AUTOLOAD_CONFIG",$path."/config/");
include_once $path."/lib/third-party/autoload/__autoload.php";

$path1 = !empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : (!empty($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : '');
try{
    $objMailer = ncRestUrlParserFactory::getInstance($ymlPath);
    $mailer = $objMailer->parseUrl($path1);
    $aa = $objMailer->getMandatoryRequestData();

    echo $objMailer->getCallingMethod();
    echo $objMailer->getCallingClass();
    $cc = $objMailer->getOptionalRequestData();

    print_R($cc);
    print_R($aa);die;
    print_R($arrPathInfo);die;

}catch(Exception $e){
    echo $e->getMessage();die;
}
