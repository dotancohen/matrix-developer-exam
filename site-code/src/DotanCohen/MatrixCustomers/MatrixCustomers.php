<?php

namespace DotanCohen\MatrixCustomers;

use DotanCohen\MatrixCustomers\Routes\RestRoute;
use DotanCohen\PdoFactory\PdoFactory;

class MatrixCustomers {

	
	protected $className;
	protected $classMethod;
	protected $requestParams;
	protected $requestBody;

	// Routes hard coded here. This could be made more elegant in production.
	// Remove leading and trailing slashes. In prod this would be more robust.
	const ROUTES =[
		'GET' => [
			'customer/id' => [['RestRouteGet', 'customerID'], true],
			'customer/id_gov' => [['RestRouteGet', 'customerIdGov'], true],
			'customer/phone' => [['RestRouteGet', 'customerPhone'], true],
		],
		'POST' => [
			'customer' => [['RestRoutePost', 'customer'], true],
		],
		'PUT' => [
			'customer' => [['RestRoutePut', 'customer'], true],
		],
		'DELETE' => [
			'customer' => [['RestRouteDelete', 'customer'], true],
		],
	];
	
	
	public function __construct(string $method_http, string $route, ?\stdClass $requestBody=null)
	{
		// Obviously in production this would be far more elegant
		if (!array_key_exists($method_http, self::ROUTES)) {
			$resp = ["error" => "Unsupported HTTP Method"];
			RestRoute::response($resp, 405);
			exit();
		}

		$method_class = null;
		foreach (self::ROUTES[$method_http] as $k=>$v) {
			if ( substr($route,0,strlen($k)) === $k) {
				// $v[0] Route Method
				// $v[1] Requires Auth
				if ( $v[1] && !self::authenticateUser() ) {
					$resp = ["error" => "Unauthenticated user"];
					RestRoute::response($resp, 401);
					exit();
				}
				$class_name = $v[0][0];
				$method_class = $v[0][1];
				$this->requestParams = self::getParams($k, $route);
				break;
			}
		}

		if ( !$method_class ) {
			$resp = ["error" => "Invalid Route"];
			RestRoute::response($resp, 404);
			exit();
		}

		$file_name = __DIR__."/Routes/{$class_name}.php";
		if ( !file_exists($file_name) ) {
			$resp = ["error" => "Unsupported HTTP Method"];
			RestRoute::response($resp, 405);
			exit();
		}
		
		$this->className = __NAMESPACE__ . "\\Routes\\" . $class_name;
		$this->classMethod = $method_class;
		$this->requestBody = $requestBody;
	}
	
	
	public static function getParams($base_route, $route) : array
	{
		$remainder = substr($route, strlen($base_route)+1);
		return $remainder ? explode('/', $remainder) : [];
	}
	
	
	public function run() : void
	{
		call_user_func([$this->className, $this->classMethod], $this->requestParams, $this->requestBody);
	}


	protected static function authenticateUser() : bool
	{
		$headers = apache_request_headers();
		if ( !isset($headers['Authorization']) ) {
			return false;
		}

		$api_key_parts = explode(' ', $headers['Authorization']);
		if ( count($api_key_parts)<2 || strtolower($api_key_parts[0])!=='bearer' ) {
			return false;
		}

		$pdo = PdoFactory::getPdo();
		$table = "users";

		$sql = "SELECT id";
		$sql.= " FROM {$table}";
		$sql.= " WHERE api_key=:api_key";
		$sql.= " LIMIT 1";

		$params = [
			':api_key' => $api_key_parts[1],
		];

		$stmt = $pdo->prepare($sql);
		$stmt->execute($params);
		$row = $stmt->fetch(\PDO::FETCH_ASSOC);
		if ( !$row ) {
			return false;
		}

		return true;
	}


}