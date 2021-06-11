<?php

namespace DotanCohen\MatrixCustomers;

class MatrixCustomers {
	
	public function __construct($method_http, $route, $requestBody)
	{
		// Select a method based on inputs
		var_dump($route);
		
		
		
		// Obviously in production this would be far more elegant
		if (!method_exists($this, $method)) {
			throw new \Exception("Invalid Method");
		}
		$this->classMethod = $method;
		$this->requestBody = $requestBody;
	}
	
}