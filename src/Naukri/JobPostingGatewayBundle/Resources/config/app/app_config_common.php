<?php
define('JP_ROOT_DIR', realpath(dirname(__DIR__).'/../../../../../'));
define('JOBPOSTING_BUNDLE', JP_ROOT_DIR.'/src/Naukri/JobPostingGatewayBundle');
define('NC_CACHE_CONFIG',JP_ROOT_DIR.'/Resources/config/cache');
define('NC_DB_CONFIG', JOBPOSTING_BUNDLE.'/Resources/config/database');
define('ENCRYPT_CONFIG_PATH',JP_ROOT_DIR.'/app/config');

define('CL_CONFIG', JOBPOSTING_BUNDLE.'/Resources/config/logs');



define('TEMP_SSO_ON', 0);

define('ORE_APP_ID', 136);

define('DB_APP_KEY', 'jobposting');

//Nodes defined for Single Sign On
define('_COOKIE_DOMAIN', 'infoedge.com');
define('NODE_SSO', 'sso');

define('SUMS_SERVICE_ID', 107);
define('SUMS_SERVICE_VERSION', 4);
define('SUMS_SERVICE_CONN_TIMEOUT', 1);
define('SUMS_SERVICE_READ_TIMEOUT', 3000000);

define('RP_APP_ID',8);
define('RP_SERVICE_VERSION',4);
define('RP_CONNECTION_TIMEOUT', 0.3);
define('RP_READ_TIMEOUT', 800000);
define('_RP_DATA_LENGTH', 70);

define('usernameToBeUpdated', 0);
define('usernameRecordUnderProcess', 1);
define('usernameUpdated', 2);


define('NC_ENCRYPT_CONFIG',JP_ROOT_DIR.'/src/Naukri/JobPostingGatewayBundle/Resources/config/encryption');

define('UGPREMIUMFLAG',1);
define('PGPREMIUMFLAG',2);
define('STAR_RATING',2);

define('RMS_CAT_ID',113);
define('RMS_ENTERPRISE',108);
define('RMS_CONSULTANT', 110);
define('RMS_PRO', 93);
define('RMS_FB_TAB', 92);
define('RMS_FB_TAB_TOPUP', 91);

define('BITFLAG_RESPMGR_BRV', 1); //2nd, 1st 01 - BRV
define('BITFLAG_RESPMGR_APPLYINTEGRATION', 2); //2nd, 1st 10 - Apply Integration
define('BITFLAG_REFERRALJOB_VAL',4096);

define('APPLYTYPE_UNREG', 1);
define('APPLYTYPE_APPLYWITHNAUKRI', 2);
define('APPLYTYPE_BOTH', 3);
define('USERNAMETOBEUPDATED', 0);
define('USERNAMERECORDUNDERPROCESS', 1);
define('USERNAMEUPDATED', 2);
define('USERNAMEAPIKEY', 'uCMvvC5YTELdqesE4e5966C36nLt6vt6nTcNZnRycqUR8TLCP8XTneAduy8pLPhfvd78HyX9W3L34trapk2g2uUavAkqjj35mKN8BbCRUk7umJSDsMBXUy9jCw5mhK64');

define('AWN_SUBCAT_ID', 97);
define('AWN_EXPIRE_JOB_INTERVAL', 30);

define('RESTRICT_NFL_DURATION', 48); //This is number of hours (from the job POSTED date) after which the NFL can not be applied to the Job.

define('DUPLICATE_ERROR_MSG', 'Duplicate Apply ! An application for this candidate already exists in the system.');

define('REFERRAL_CAT_ID',114);
define('ENTERPRISESSUBCATID',101);
define('FULLREFSUBCAT',89);
define('TRIALREFSUBCAT',90);

define("BITFLAG_RMJ_PRIVATE_VALUE", 128);
define("BITFLAG_FREE_JOB_VALUE", 4);
define("BITFLAG_DROP_CV_VALUE", 2048);

define('BRV', 'BRV');
define('SM', 'SM');
define('GNB_APP_ID', 113);

define("JOBSRCHURL","http://www.naukri.com/mynaukri/mn_newminnernew.php?f=");
define('JOB_LISTINGS_URL',"http://www.naukri.com/");
define("JOBSEARCH_JD_DB_TAG", "hotjobs1");

define("SYSTEM_ID","1");
define("APP_ID","1");

define('ORE_JD_FILE_UPLOAD_FORM_KEY', 'F67jss1i3n5g8h');
define('ORE_PHOTO_UPLOAD_FORM_KEY', 'F53be3291581a3');
define('ORE_PPT_UPLOAD_FORM_KEY', 'F53be32db5db04');
define('ORE_TEAM_MEMBER_UPLOAD_FORM_KEY', 'F60r3r56g456ty');

define("ORE_CUSTOM_TEMPLATES_DIR", "/apps/jobposting/templates/current/");

define("NAUKRI_BOARD", "1");
define("CAREERSITE_BOARD", "2");
define("REFERRAL_BOARD", "43");
define("IJP_BOARD", "29");

/* keeping arbitrary values 98 and 99 for validation workflow only and this would not be used for posting */
define("VENDOR_JOB", 98);
define("EXTERNAL_JOB", 99);

define("NCREST_REFERER_URL_SUBSTR","resource");
define("NCREST_SHOW_CODE", 0);

define("INSTA_JOB", "instajob");
define("OBJECT_IDENTIFIER", "°°Object°°");
