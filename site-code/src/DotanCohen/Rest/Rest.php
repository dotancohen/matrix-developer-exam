<?php
namespace DotanCohen\Rest;

class Rest {

	
	public static function getVersion()
	{
		$uri = $_SERVER['REQUEST_URI'];
		return explode('/', $uri)[1];
	}
	
}