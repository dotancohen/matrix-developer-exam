<?php
use DotanCohen\Rest\Rest;

include "../vendor/autoload.php";

$world = Rest::getVersion();
echo "Hello, {$world}!";
