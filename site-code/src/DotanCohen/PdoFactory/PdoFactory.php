<?php

namespace DotanCohen\PdoFactory;

class PdoFactory {
	
	
	protected static $host;
	protected static $port;
	protected static $database;
	protected static $user;
	protected static $pass;
	
	
	public static function init($host, $port, $database, $user, $pass)
	{
		self::$host = $host;
		self::$port = $port;
		self::$database = $database;
		self::$user = $user;
		self::$pass = $pass;
	}
	
	
	public static function getPdo() : \PDO
	{
		if ( !self::$host || !self::$port || !self::$database || !self::$user || !self::$pass ) {
			throw new \Exception("PdoFactory not initialized");
		}

		$host = self::$host;
		$port = self::$port;
		$database = self::$database;
		$dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
		$options = [
			\PDO::ATTR_EMULATE_PREPARES => FALSE
		];
		
		$pdo = new \PDO($dsn, self::$user, self::$pass, $options );
		
		return $pdo;
	}
	
}