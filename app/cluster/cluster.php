<?php

$baseUrl = strstr($_SERVER['HTTP_HOST'], '.');
$res = strstr($baseUrl, ":", true);
if ($res) $baseUrl = $res;

define("CLUSTER_URL", ltrim($baseUrl, '.'));
