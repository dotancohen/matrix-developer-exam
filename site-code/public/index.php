<?php
use DotanCohen\Rest\Rest;
use DotanCohen\MatrixCustomers\MatrixCustomers;

include "../vendor/autoload.php";

$ini_file = __DIR__ . "/../.env";
if (!file_exists($ini_file)) {
	throw new \Exception("Dotenv File Not Found.");
}
$env = parse_ini_file($ini_file);

$version = Rest::getVersion(); // Normally we would invoke different classes per version
$method_http = Rest::getMethod();
$route = Rest::getRoute();
$body = Rest::getBody();


// Normally I would use a routing library here.
// In keeping with the spirit of "vanilla PHP" I'm writing something simple yet extensible here.
$matrix = new MatrixCustomers($method_http, $route, $body);
$matrix->run();
