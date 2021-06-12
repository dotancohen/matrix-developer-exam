<?php
namespace DotanCohen\Rest;

class Rest {

	
	public static function getVersion() : string
	{
		$uri = $_SERVER['REQUEST_URI'];
		return explode('/', $uri)[1];
	}
	
	
	public static function getMethod() : string
	{
		return $_SERVER['REQUEST_METHOD'];
	}
	

	public static function getRoute() : string
	{
		$uri = trim($_SERVER['REQUEST_URI'], '/');
		$uri = trim(strchr($uri, '/'), '/');
		return $uri;
	}
	

	public static function getBody() : ?\stdClass
	{
		// Assumes that body is JSON. In production this would be more robust.
		$body = file_get_contents('php://input');
		return json_decode($body);
	}

	
}