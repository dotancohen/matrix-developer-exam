<?php

namespace DotanCohen\MatrixCustomers;

class MatrixCustomers {

	
	protected $className;
	protected $classMethod;
	protected $requestParams;
	protected $requestBody;

	// Routes hard coded here. This could be made more elegant in production.
	// Remove leading and trailing slashes. In prod this would be more robust.
	const ROUTES =[
		'GET' => [
			'customer/id_gov' => ['RestRouteGet', 'customerIdGov'],
			'customer/phone' => ['RestRouteGet', 'customerPhone'],
		],
		'POST' => [
			'customer' => ['RestRoutePost', 'customer'],
		],
		'PUT' => [
			'customer' => ['RestRoutePut', 'customer'],
		],
		'DELETE' => [
			'customer' => ['RestRouteDelete', 'customer'],
		],
	];
	
	
	public function __construct(string $method_http, string $route, ?\stdClass $requestBody=null)
	{
		// Obviously in production this would be far more elegant
		if (!array_key_exists($method_http, self::ROUTES)) {
			throw new \Exception("Unsupported HTTP Method");
		}

		$method_class = null;
		foreach (self::ROUTES[$method_http] as $k=>$v) {
			if ( substr($route,0,strlen($k)) === $k) {
				$class_name = $v[0];
				$method_class = $v[1];
				$this->requestParams = self::getParams($k, $route);
				break;
			}
		}

		if ( !$method_class ) {
			throw new \Exception("Invalid Route");
		}

		$file_name = __DIR__."/Routes/{$class_name}.php";
		if ( !file_exists($file_name) ) {
			throw new \Exception("Unsupported HTTP Method");
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
	
	
}