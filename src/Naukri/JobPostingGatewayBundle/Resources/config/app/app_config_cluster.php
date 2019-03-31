<?php
require_once realpath(dirname(__DIR__).'/../../../../../').'/app/cluster/cluster.php';
error_reporting(0);
define('JP_CMD_ROOT_DIR', '/apps/jpgateway/current');
define("NC_FILEUPLOAD_SERVICE_ENV", "DEV");

define('SUMS_SERVICE_HOST_PORT', 'naukri-sumssp-service-v1.naukri-services-test2:80');

define('JOBPOSTING_SERVICE_ENV', 'test');
define('MAKESENSEKEYWORDSAPI', 'r-makesense-service:8080/externalapi');
define('MAKESENSE_IDTOKEYWORDMAPPING','r-makesense-service:8080/idtokeywordmappingapi');


define('CONNECT_TIME_OUT', 5000);
define('REQUEST_TIME_OUT', 5000);
define('PEST_CONNECT_TIMEOUT', 5);
define('PEST_CURLOPT_TIMEOUT', 5);


define('NLOGGER_ENV', 'prod');

define('_AUTH_URL', 'https://login.recruit.'.CLUSTER_URL.'/Login/login');
define('_AUTHENTICATION_URL', 'https://login.recruit.'.CLUSTER_URL.'/Login/authenticate');
define('_JP_LOGOUT_URL', 'https://login.recruit.'.CLUSTER_URL.'/Login/logout');

define("JPIMAGESURL", "http://test1.static.infoedge.com/rstatic/images");

define('LOGOUT_URL', 'http://jobposting.'.CLUSTER_URL.'/logout');

define("BMSURL", "http://d8.zedo.com/jsc/d8/ff2.html?n=1380;c=1056;s=1;w=468;h=60");

define("JOBLISTING_URL", 'http://jobposting.'.CLUSTER_URL.'/JobListing/default');
define('JOBPOSTING_API_URL', 'http://jobposting.'.CLUSTER_URL.'/API.php/');

define('JPDOMAIN', 'jobposting.'.CLUSTER_URL);

define("API_APPLY_URL", 'http://apply.'.CLUSTER_URL.'/apply/applywithnaukri');
define("JPONLINE", 'http://jobposting.'.CLUSTER_URL);

define("JOBSRCHURL", "http://jobsearch.".CLUSTER_URL."/mynaukri/mn_newminnernew.php?f=");

define("RESDEXMAKESENSEAPI", "http://semantic.resdex.com:6666/generateresdexquery_jp");

define("URL_SHORTNER", 0);

define('RP_SERVICE_ENV', 'DEV');
define('RP_HOST_PORT', 'naukri-rpsp-service-v1.naukri-services-test2:80');

define("SEARCHURL", "http://www.naukri.com/mynaukri/mn_newminnernew.php");

define("STATICIMAGESURL", 'http://static.'.CLUSTER_URL.'/s/4p/107/');

define('REFERRALDOMAIN', 'referralrecruit.'.CLUSTER_URL);
define('_PROTOCOL_', 'http');
define("_AUTHENVIRONMENT", "cluster");

define('CSM_GET_QUESTIONAIRE', "http://csm.".CLUSTER_URL."/restApi/getQuestionnaire");
define("ROLE_BASED_QUESTIONNAIRE_SERVICE_URL", "172.16.3.211:7181");
$BASE_DIR = realpath(dirname(__FILE__) . '/../');
define('MIS_LOG_PATH', "$BASE_DIR/log/mis");
define("SM_QUESTIONNAIRE_SAVE", "http://csm.".CLUSTER_URL."/restApi/createQuestionnaire");
define("SM_QUESTIONNAIRE_ATTACH", "http://csm.".CLUSTER_URL."/restApi/attachQuestionnaireToJob");
define("CSM_RESPONSE_CNT_API", "http://csm.".CLUSTER_URL."restApi/getRespCountForJobByStatus");
define("CSM_RESPONSE_CNT_DATE_API", "http://csm.".CLUSTER_URL."/restApi/getResponseCountForJobsByDate");

define("CSM_RESPONSE_CNT_DATE_RANGE_API", "http://csm.".CLUSTER_URL."/restApi/responseCountByDateRange");

define("CUSTOM_CONFIGURATOR_GET_API","http://customapply.".CLUSTER_URL."/customApplyApi/getConfiguratorFields");

define("CUSTOM_CONFIGURATOR_SAVE_API","http://customapply.".CLUSTER_URL."/customApplyApi/saveConfiguratorFields");

define('AUTHKEY_CA','x60KhIm81rCo');


//Referral APIs
define('REFERRAL_COMPANY_SETTING_API','http://referral.'.CLUSTER_URL.'/api/v1/getCompanySettings');

define("APPLY_AMR_FFEDBACK_URL", "http://apply.".CLUSTER_URL."/apply/amrfeedback");

define("RMS_SERVICES_BASE_URL", "http://rms-services.test2.32251.cluster.infoedge.com");
define("CONVERTER_SERVICE_BASE_URL", RMS_SERVICES_BASE_URL . "/rms-documentconverter-services/v0/");
#define("COMPANY_SERVICE_BASE_URL", getenv(NC_SERVICES_URL) . "/company-services/" . getenv(SERVICE_COMPANY_VERSION));
#define("JOB_SERVICE_BASE_URL", getenv( NC_SERVICES_URL) . "/job-services/" . getenv(SERVICE_JOB_VERSION));
define("NC_SERVICES_BASE_URL", "http://ncservices.test2.32285.cluster.infoedge.com/");
define("COMPANY_SERVICE_BASE_URL", NC_SERVICES_BASE_URL . "company-services/v1");
define("JOB_SERVICE_BASE_URL", NC_SERVICES_BASE_URL . "job-services/v1");
define("JOB_SERVICE_REPORTS_URL", JOB_SERVICE_BASE_URL . "/job/report");

define("RMS_API_URL", "http://rms-requirement-service.test2.30408.cluster.infoedge.com/rms-requirement-services/v0");
define("RMS_REC_API_URL", "http://rms-recruiter-config-service.test2.30408.cluster.infoedge.com/rms-recruiter-config-services/v2");
define("QUES_SERVICE_URL","http://naukriservices.test2.30560.cluster.infoedge.com/questionnaire-services/v1-0-3-beta23");
define("RMS_CSM_API_URL", "http://csm.test2.30468.cluster.infoedge.com");
define("HIRING_TEAM_BY_GROUPID", RMS_CSM_API_URL . "/requirement/hiringTeam");

define("MNR_MEDIA_URL",'https://recruit.'.CLUSTER_URL);
define("COMPANY_LOGO_URL",'https://www.naukri.com/hotjobs/images/');
define("LOGO_BASE_URL", "https://img.naukimg.com/logo_images/v2");
define("MICROSITEURL","https://test2.microsite.infoedge.com/");
define("MNR_PHOTOS_URL",MNR_MEDIA_URL.'/Services/fetchDetailsForMediaByCompany');
define("ORE_GATEWAY_URL", 'https://jpgateway.'.CLUSTER_URL);

define("BASE_STATIC_URL", "https://static.".CLUSTER_URL."/s/5p/136/docker");

define("RP_API_URL", "https://rp.test2.naukri-test2.cluster.infoedge.com/service.php");
define("RP_REGISTER_API_URL", RP_API_URL . "/register/register");

define("JOB_PUBLISHER_URL", "http://jobs-publisher-services.test2.31037.cluster.infoedge.com/jobs-publisher-services/v1/");
define("RP_SEARCH_API_URL", "https://rpsearch.test2.naukri-test2.cluster.infoedge.com/recruiters/rpapi");
define("RP_GET_VCARD_API_URL", RP_SEARCH_API_URL . "/v1/vcardbulk");
define("FSS_API_URL", "http://192.168.40.139:9292");
define("FSS_SYSTEM_ID", "JOBPOSIMG");
define("FSS_SAVE_IMAGE_API_URL", FSS_API_URL."/files");
define("NC_ENC_KEY_DIR", dirname(__FILE__)."/..");
define("PHOTO_SERVICE_IMAGE_URL","http://192.168.40.139/Photoservice/web/naukriJobSeekerPhoto.php");

//define("PAF_SERVICE_BASE_URL", "http://192.168.2.116:8071/paf/filters");
define("PAF_SERVICE_BASE_URL", "http://services.test2.naukri-services-test2.cluster.infoedge.com/paf-service/v1/paf/filters");
define("NFL_SERVICE_BASE_URL", JOB_SERVICE_BASE_URL . "/nfl");
define("PUBLISHER_SERVICE_BASE_URL", "http://publisherServices.test2.32299.cluster.infoedge.com");
define("CV_RECO_GENERATION_SERVICE", "http://cvrecommendations.jobposting.analytics.resdex.com/jobposted");
define("INSTA_PRICE_API","https://recruit.test2.damanpreet-singh-test2.cluster.infoedge.com/rCommerce/client/getInstaProductPriceDetails");
define("REFERRAL_API_URL", "http://referral.test2.31475.cluster.infoedge.com/api/v1/");
define("ASYNC_MAIL_URL", "http://communication.services.resdex.com/v0/comm/request/mail");


define('OPEN_COMPANY_ID', 168613);
define('OPEN_USER_ID', 76866550);
