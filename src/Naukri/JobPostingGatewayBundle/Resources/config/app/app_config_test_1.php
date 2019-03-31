<?php
define('JP_CMD_ROOT_DIR','/apps/nfl/current');

define('SUMS_SERVICE_HOST_PORT', '172.16.2.179:8100');


define('JOBPOSTING_SERVICE_ENV','test');
define('MAKESENSEKEYWORDSAPI','172.16.3.130:3333/externalapi');
define('MAKESENSE_IDTOKEYWORDMAPPING','172.16.3.130:3333/idtokeywordmappingapi');

define('CONNECT_TIME_OUT', 5000);
define('REQUEST_TIME_OUT', 600000);
define('PEST_CONNECT_TIMEOUT', 5);
define('PEST_CURLOPT_TIMEOUT', 5);


define('NLOGGER_ENV','test1');

define('_DEFAULT_LANDING_URL','http://dev1.infoedge.com:8010/nfl/web/app_dev.php/jp/companyJob');

define('_AUTH_URL', 'http://test1.login.recruit.infoedge.com/Login/login');
define('_AUTHENTICATION_URL', 'http://test1.login.recruit.infoedge.com/Login/authenticate');
define('_JP_LOGOUT_URL', 'http://test1.login.recruit.infoedge.com/Login/logout');

define("JPIMAGESURL", "http://test1.static.infoedge.com/rstatic/images");
define('LOGOUT_URL', 'http://test1.nfl.infoedge.com/logout');

define("BMSURL", "http://d8.zedo.com/jsc/d8/ff2.html?n=1380;c=1056;s=1;w=468;h=60");

define("JOBLISTING_URL", "http://test1.posting.infoedge.com/JobListing/default");

define('JOBPOSTING_API_URL',"http://test1.posting.infoedge.com/API.php/");

define('JPDOMAIN','test1.posting.infoedge.com');

define("API_APPLY_URL", "http://test1.apply.infoedge.com/apply/applywithnaukri");

define("JPONLINE", "http://test1.posting.infoedge.com");

define("JOBSRCHURL","http://test1.jobsearch.infoedge.com/mynaukri/mn_newminnernew.php?f=");

define("RESDEXMAKESENSEAPI","http://192.168.2.114:5555/generateresdexquery_csm");

define("URL_SHORTNER",0);

define('RP_SERVICE_ENV', 'QA1');
define('RP_HOST_PORT','172.16.2.179:5555');

define("SEARCHURL", "http://test1.jobsearch.infoedge.com/mynaukri/mn_newminnernew.php");

define("STATICIMAGESURL", "http://test1.static.infoedge.com/s/4/107/i");
define("_AUTHENVIRONMENT","qa1");

define('CSM_GET_QUESTIONAIRE',"http://test1.sm.infoedge.com/restApi/getQuestionnaire");

define("ROLE_BASED_QUESTIONNAIRE_SERVICE_URL", "172.16.3.211:7181");
$BASE_DIR = realpath(dirname(__FILE__) . '/../');
define('MIS_LOG_PATH',"$BASE_DIR/log/mis");
define("SM_QUESTIONNAIRE_SAVE", "test1.sm.infoedge.com/restApi/createQuestionnaire");
define("SM_QUESTIONNAIRE_ATTACH", "test1.sm.infoedge.com/restApi/attachQuestionnaireToJob");
define("CSM_RESPONSE_CNT_API","http://test1.sm.infoedge.com/restApi/getRespCountForJobByStatus");
define("CSM_RESPONSE_CNT_DATE_API","http://test1.sm.infoedge.com/restApi/getResponseCountForJobsByDate");

define("CSM_RESPONSE_CNT_DATE_RANGE_API", "http://test1.sm.infoedge.com/restApi/responseCountByDateRange");

define("CUSTOM_CONFIGURATOR_GET_API","http://test1.customapply.infoedge.com/customApplyApi/getConfiguratorFields");

define('CUSTOM_CONFIGURATOR_SAVE_API','http://test1.customapply.infoedge.com/customApplyApi/saveConfiguratorFields');

define('AUTHKEY_CA','x60KhIm81rCo');

define("REFERRAL_COMPANY_SETTING_API","http://test1.referral.infoedge.com/api/v1/getCompanySettings");

define("APPLY_AMR_FFEDBACK_URL", "http://test1.apply.infoedge.com/apply/amrfeedback");

define("BRV_LISTING_URL", "https://test1.response.naukri.com/response/list");
define("RMS_PROJECT_INBOX_URL", "https://test1.rms.naukri.com/profile/project/inbox");
define("PAF_FORM_URL", "https://test1.posting.naukri.com/newpaf/pafForm");