<?php

namespace DotanCohen\MatrixCustomers;

class MatrixCustomers {
	
	public function __construct($method_http, $route, $requestBody)
	{
		// Select a method based on inputs
		var_dump($route);
		$method = "beer";
		
		
		
		// Obviously in production this would be far more elegant
		if (!method_exists($this, $method)) {
			throw new \Exception("Invalid Method");
		}
		$this->classMethod = $method;
		$this->requestBody = $requestBody;
	}
	
	
	public function run()
	{
		if (!method_exists($this, $this->classMethod)) {
			throw new \Exception("Invalid Method");
		}
		
		$this->{$this->classMethod}();
	}
	
	
	public function beer()
	{
		echo "BEER";
	}
	
}