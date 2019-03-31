<?php
define('JP_CMD_ROOT_DIR', '/apps/jpgateway/current');
define("NC_FILEUPLOAD_SERVICE_ENV", "prod");
define('SUMS_SERVICE_HOST_PORT', '{sumsservice.resdex.com}');


define('JOBPOSTING_SERVICE_ENV', 'test');
define('MAKESENSEKEYWORDSAPI', 'makesense.resdex.com:3340/externalapi');
define('MAKESENSE_IDTOKEYWORDMAPPING','makesense.resdex.com:3340/idtokeywordmappingapi');


define('CONNECT_TIME_OUT', 5000);
define('REQUEST_TIME_OUT', 5000);
define('PEST_CONNECT_TIMEOUT', 5);
define('PEST_CURLOPT_TIMEOUT', 5);


define('NLOGGER_ENV', 'prod');

define('_AUTH_URL', 'https://login.recruit.naukri.com/Login/login');
define('_AUTHENTICATION_URL', 'https://login.recruit.naukri.com/Login/authenticate');
define('_JP_LOGOUT_URL', 'https://login.recruit.naukri.com/Login/logout');

define("JPIMAGESURL", "https://static.naukimg.com/rstatic/images");

define('LOGOUT_URL', 'https://posting.naukri.com/logout');

define("BMSURL", "http://d8.zedo.com/jsc/d8/ff2.html?n=1380;c=1056;s=1;w=468;h=60");

define("JOBLISTING_URL", "https://posting.naukri.com/JobListing/default");
define('JOBPOSTING_API_URL', "https://posting.naukri.com/API.php/");

define('JPDOMAIN', 'posting.naukri.com');

define("API_APPLY_URL", "http://apply.naukri.com/apply/applywithnaukri");
define("JPONLINE", "https://posting.naukri.com");

define("JOBSRCHURL", "http://www.naukri.com/mynaukri/mn_newminnernew.php?f=");

define("RESDEXMAKESENSEAPI", "http://semantic.resdex.com:6666/generateresdexquery_jp");

define("URL_SHORTNER", 0);

define('RP_SERVICE_ENV', 'PROD');
define('RP_HOST_PORT', '{rpservice.master.resdex.com}');

define("SEARCHURL", "http://www.naukri.com/mynaukri/mn_newminnernew.php");

define("STATICIMAGESURL", "https://static.naukimg.com/s/4/107/i");

define('REFERRALDOMAIN', 'referralrecruit.com');
define('_PROTOCOL_', 'https');
define("_AUTHENVIRONMENT", "prod");
define('OUTBOUND_PROXY_SERVER', 'http://webproxy.ieil.net:8081/');

define('CSM_GET_QUESTIONAIRE', "http://service.sm.resdex.com/restApi/getQuestionnaire");
define("ROLE_BASED_QUESTIONNAIRE_SERVICE_URL", "{jobservice.master.resdex.com}");
$BASE_DIR = realpath(dirname(__FILE__) . '/../');
define('MIS_LOG_PATH', "$BASE_DIR/log/mis");
define("SM_QUESTIONNAIRE_SAVE", "http://service.sm.resdex.com/restApi/createQuestionnaire");
define("SM_QUESTIONNAIRE_ATTACH", "http://service.sm.resdex.com/restApi/attachQuestionnaireToJob");
define("CSM_RESPONSE_CNT_API", "http://service.sm.resdex.com/restApi/getRespCountForJobByStatus");
define("CSM_RESPONSE_CNT_DATE_API", "http://service.sm.resdex.com/restApi/getResponseCountForJobsByDate");

define("CSM_RESPONSE_CNT_DATE_RANGE_API", "http://service.sm.resdex.com/restApi/responseCountByDateRange");

define('CUSTOM_CONFIGURATOR_GET_API','http://service.customapply.resdex.com/customApplyApi/getConfiguratorFields');

define('CUSTOM_CONFIGURATOR_SAVE_API','http://service.customapply.resdex.com/customApplyApi/saveConfiguratorFields');

define('AUTHKEY_CA','y71liJn92sDp');

//Referral APIs
define("REFERRAL_COMPANY_SETTING_API","http://service.referral.resdex.com/api/v1/getCompanySettings");

define("APPLY_AMR_FFEDBACK_URL", "http://service.apply.resdex.com/apply/amrfeedback");
define("APPLY_AMR_RESPONSE_URL", "http://service.apply.resdex.com/apply/amrResponse");

define("BRV_LISTING_URL", "https://response.naukri.com/response/list");
define("RMS_PROJECT_INBOX_URL", "https://rms.naukri.com/profile/project/inbox");
define("PAF_FORM_URL", "https://posting.naukri.com/newpaf/pafForm");

define("ORE_SERVICES_BASE_URL", "http://service.recruiter.resdex.com/");
define("RMS_SERVICES_BASE_URL", "https://service.rms.resdex.com/");
define("CONVERTER_SERVICE_BASE_URL", RMS_SERVICES_BASE_URL . "rms-documentconverter-services/v0/");
#define("COMPANY_SERVICE_BASE_URL", getenv(NC_SERVICES_URL) . "/company-services/" . getenv(SERVICE_COMPANY_VERSION));
#define("JOB_SERVICE_BASE_URL", getenv( NC_SERVICES_URL) . "/job-services/" . getenv(SERVICE_JOB_VERSION));
define("NC_SERVICES_BASE_URL", "http://ncservices.test2.32165.cluster.infoedge.com/");
define("COMPANY_SERVICE_BASE_URL", NC_SERVICES_BASE_URL . "company-services/v1");
define("JOB_SERVICE_BASE_URL", NC_SERVICES_BASE_URL . "job-services/v1");
define("JOB_SERVICE_REPORTS_URL", JOB_SERVICE_BASE_URL . "/job/report");

define("RMS_API_URL", "http://rms-requirement-service.dev.30858.cluster.infoedge.com");
define("QUES_SERVICE_URL","http://naukriservices.test2.30560.cluster.infoedge.com/questionnaire-services/v1-0-3-beta23");
define("HIRING_TEAM_SERVICE_URL", RMS_API_URL . "/requirement/v0/");

define("RMS_CSM_API_URL", "http://csm.dev.30624.cluster.infoedge.com");
define("HIRING_TEAM_BY_GROUPID", RMS_CSM_API_URL . "/requirement/hiringTeam");

define("MNR_MEDIA_URL",'http://recruit.'.CLUSTER_URL);
define("COMPANY_LOGO_URL",'https://www.naukri.com/hotjobs/images/');
define("MNR_PHOTOS_URL",MNR_MEDIA_URL.'/Services/fetchDetailsForMediaByCompany');
define("ORE_GATEWAY_URL", 'https://hiring.naukri.com');
define("MICROSITEURL","https://companies.naukri.com/");
define("BASE_STATIC_URL", "http://static.naukimg.com/s/136/docker");
define("LOGO_BASE_URL", "https://img.naukimg.com/logo_images/v2");

/* RP API URLs */
define("RP_API_URL", "http://service.naukrirecruiter.resdex.com/service.php");
define("RP_REGISTER_API_URL", RP_API_URL . "/register/register");

define("RP_SEARCH_API_URL", "https://www.naukri.com/recruiters/rpapi");
define("RP_GET_VCARD_API_URL", RP_SEARCH_API_URL . "/v1/vcardbulk");
define("FSS_API_URL", "http://192.168.40.139:9292");
define("FSS_SYSTEM_ID", "JOBPOSIMG");
define("FSS_SAVE_IMAGE_API_URL", FSS_API_URL."/files");
define("NC_ENC_KEY_DIR", dirname(__FILE__)."/..");
define("PHOTO_SERVICE_IMAGE_URL","http://192.168.40.139/Photoservice/web/naukriJobSeekerPhoto.php");

define("ANALYTICS_SERVICE_BASE_URL", "https://analytics.cvrecommendation.resdex.com");
define("PAF_SERVICE_BASE_URL", "http://apply.restapis.services.resdex.com/paf/filters");
define("NFL_SERVICE_BASE_URL", JOB_SERVICE_BASE_URL . "/nfl");
define("PUBLISHER_SERVICE_BASE_URL", "http://publisherServices.test2.32299.cluster.infoedge.com");
define("INSTA_PRICE_API","https://recruit.test2.damanpreet-singh-test2.cluster.infoedge.com/rCommerce/client/getInstaProductPriceDetails");

define('OPEN_COMPANY_ID', 238592);
define('OPEN_USER_ID', 346399);
