<?php
use DotanCohen\Rest\Rest;

include "../vendor/autoload.php";

$version = Rest::getVersion();
$method_http = Rest::getMethod();
$route = Rest::getRoute();
$body = Rest::getBody();

echo "Hello, {$version}!";
