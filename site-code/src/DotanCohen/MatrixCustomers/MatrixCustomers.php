<?php

namespace DotanCohen\MatrixCustomers;

class MatrixCustomers {

	
	protected $className;
	protected $classMethod;
	protected $requestBody;

	// Routes hard coded here. This could be made more elegant in production.
	// Remove leading and trailing slashes. In prod this would be more robust.
	const ROUTES = array(
		'GET' => array(
			'customer/id_gov' => ['RestRouteGet', 'customerIdGov'],
			'customer/phone' => ['RestRouteGet', 'customerPhone'],
		),
		'POST' => array(
			'customer' => ['RestRoutePost', 'customer'],
		),
		'PUT' => array(
			'customer' => ['RestRoutePut', 'customer'],
		),
		'DELETE' => array(
			'customer' => ['RestRouteDelete', 'customer'],
		),
	);
	
	
	public function __construct(string $method_http, string $route, string $requestBody=null)
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
				break;
			}
		}

		if ( !$method_class ) {
			throw new \Exception("Invalid Route");
		}

		$file_name = __DIR__."/{$class_name}.php";
		if ( !file_exists($file_name) ) {
			throw new \Exception("Unsupported HTTP Method");
		}
		
		$this->className = __NAMESPACE__ . "\\" . $class_name;
		$this->classMethod = $method_class;
		$this->requestBody = $requestBody;
	}
	
	
	public function run() : void
	{
		call_user_func([$this->className, $this->classMethod], $this->requestBody);
	}
	
	
}