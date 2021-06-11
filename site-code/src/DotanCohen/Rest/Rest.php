<?php
namespace DotanCohen\Rest;

class Rest {

	
	public static function getVersion()
	{
		$uri = $_SERVER['REQUEST_URI'];
		return explode('/', $uri)[1];
	}
	
	
	public static function getMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}
	

	public static function getRoute()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$parts = explode('/', $uri);
		return array_slice($parts, 2);
	}
	

	public static function getBody()
	{
		// Assumes that body is JSON. In production this would be more robust.
		$body = file_get_contents('php://input');
		return json_decode($body);
	}

	
}