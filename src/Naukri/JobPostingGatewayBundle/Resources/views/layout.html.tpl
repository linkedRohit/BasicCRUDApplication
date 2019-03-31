<!DOCTYPE html>
<html lang="en"> 
<head>
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700"></link>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
    ~block name=title`Admin Console~/block`
    </title>
    ~block name=headlinks`~/block`
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!--  Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

</head>
<body>
    <noscript>
        <div style="font:normal 11px Verdana; color:#000; padding:2px;border-bottom:1px solid #e1deac; background:#fffbc0;"><img src="~$JPIMAGESURL`/warning.gif" width="32" height="32" hspace="5" align="absmiddle"> Javascript is disabled in your browser due to this certain functionalities will not work. <a href="~$ENABLE_JS_PATH`"target="_blank">Click Here</a>, to know how to enable it.</div>
    </noscript>

    <div class="bodyWrap">
    ~block name=body`~/block`   
    </div>
    <div class="footerHtml"></div>
    
    ~block name=js_init`
    ~/block`
</body>
</html>
