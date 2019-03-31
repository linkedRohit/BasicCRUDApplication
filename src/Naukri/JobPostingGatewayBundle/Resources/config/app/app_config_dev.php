<?php

define('BASE_APP_URL', 'http://dev2.nfl.infoedge.com');
define('BASE_API_URL', 'http://dev2.nfl.infoedge.com/api/');
define("_AUTHENVIRONMENT","dev");
$BASE_DIR = realpath(dirname(__FILE__) . '/../');
define('MIS_LOG_PATH',"$BASE_DIR/log/mis");
require_once realpath(dirname(__DIR__).'/../../../../../').'/app/cluster/cluster.php';

define('JP_CMD_ROOT_DIR','/apps/jpgateway/current');

define('SUMS_SERVICE_HOST_PORT', 'sums-service:8080');

define('JOBPOSTING_SERVICE_ENV','test');
define('MAKESENSEKEYWORDSAPI','172.16.3.130:3333/externalapi');
define('MAKESENSE_IDTOKEYWORDMAPPING','172.16.3.130:3333/idtokeywordmappingapi');


define('CONNECT_TIME_OUT', 5000);
define('REQUEST_TIME_OUT', 600000);


define('NLOGGER_ENV','dev');

define('_AUTH_URL', 'http://login.recruit.'.CLUSTER_URL.'/Login/login');
define('_AUTHENTICATION_URL', 'http://login.recruit.'.CLUSTER_URL.'/Login/authenticate');
define('_JP_LOGOUT_URL', 'http://login.recruit.'.CLUSTER_URL.'/Login/logout');

define("JPIMAGESURL", "http://test1.static.infoedge.com/rstatic/images");

define('LOGOUT_URL', 'http://jobposting.'.CLUSTER_URL.'/logout');

define("BMSURL", "http://d8.zedo.com/jsc/d8/ff2.html?n=1380;c=1056;s=1;w=468;h=60");

define("JOBLISTING_URL", 'http://jobposting.'.CLUSTER_URL.'/JobListing/default');
define('JOBPOSTING_API_URL','http://jobposting.'.CLUSTER_URL.'/API.php/');

define('JPDOMAIN','jobposting.com');

define("API_APPLY_URL", 'http://apply.'.CLUSTER_URL.'/apply/applywithnaukri');
define("JPONLINE", 'http://jobposting.'.CLUSTER_URL);

define("JOBSRCHURL","http://www.naukri.com/mynaukri/mn_newminnernew.php?f=");

define("RESDEXMAKESENSEAPI","http://semantic.resdex.com:6666/generateresdexquery_jp");

define("URL_SHORTNER",0);

define('RP_SERVICE_ENV', 'DEV');
define('RP_HOST_PORT','rp-service:8080');

define("SEARCHURL", "http://www.naukri.com/mynaukri/mn_newminnernew.php");

define("STATICIMAGESURL", 'http://static.'.CLUSTER_URL.'/s/4p/107/');

define('REFERRALDOMAIN', 'referralrecruit.'.CLUSTER_URL);
define('_PROTOCOL_','http');

//Referral APIs
define("REFERRAL_COMPANY_SETTING_API","http://dev2.referral.infoedge.com/SJ/web/app_dev.php/api/v1/getCompanySettings");

define("APPLY_AMR_FFEDBACK_URL", "http://dev2.apply.infoedge.com/web/app_dev.php/apply/amrfeedback");

define("BRV_LISTING_URL", "https://dev2.response.naukri.com/web/app_dev.php/response/list");
define("RMS_PROJECT_INBOX_URL", "https://dev2.rms.naukri.com/web/app_dev.php/profile/project/inbox");
define("PAF_FORM_URL", "https://dev2.jp.naukri.com/web/Online.php/newpaf/pafForm");
