<!DOCTYPE html>
<html> 
<head>
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700"></link>
    <meta charset="UTF-8">
    <title>
    ~block name=title`Hiring Reports~/block`
    </title>
    ~$nLogger.NLoggerLink nofilter`
    <script type="text/javascript">
        ~$nLogger.NEW_MONK_CODE nofilter`
    </script>
    <!--<link href="../../c/tooltip.css" type="text/css" rel="stylesheet">-->

    ~block name=css_init`
        ~_ncss`ore_reports_app_css~/_ncss`
    ~/block`
    ~_nscript`naukri_jquery~/_nscript`
    ~_nscript`naukri_require~/_nscript`
    ~_nscript`jp_app~/_nscript`
    ~_nscript`uba_js~/_nscript`
    ~block name=headlinks`~/block`
</head>
<body>
    <div class="headGNBWrap"></div>
    <noscript>
        <div style="font:normal 11px Verdana; color:#000; padding:2px;border-bottom:1px solid #e1deac; background:#fffbc0;"><img src="~$JPIMAGESURL`/warning.gif" width="32" height="32" hspace="5" align="absmiddle"> Javascript is disabled in your browser due to this certain functionalities will not work. <a href="~$ENABLE_JS_PATH`"target="_blank">Click Here</a>, to know how to enable it.</div>
    </noscript>

    <div class="bodyWrap">
    ~block name=body`~/block`   
    </div>
    <div class="footerHtml"></div>
    
    ~block name=js_init`
        ~_nscript`common_ore_reports_app_js~/_nscript`
        ~_nscript`ore_reports_app_js~/_nscript`
    ~/block`
    ~if $user`
        ~_nrender`~url response_type="js" app_id=~$smarty.const.ORE_APP_ID` selected=~$gnbSelect|default:'jobposting'`   userid=~$user->getId()` user_email=~$user->getEmailId()` company_name =~$user->getCompanyName()` username=~$user->getUsername()` user_type=~$user->getSuperUser()` status=~$user->getStatus()` footerFlag = true companyid=~$user->getCompanyId()` `components_gnb_lg~/url`~/_nrender` 
    ~/if`
</body>
</html>
