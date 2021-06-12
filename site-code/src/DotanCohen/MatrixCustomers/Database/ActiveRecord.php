<?php

namespace DotanCohen\MatrixCustomers\Database;

abstract class ActiveRecord {

	const MYSQL_DATETIME = 'Y-m-d H:i:s';

	public ?int $id = null;
	public array $validation_errors;

	public function __construct(?int $id=null)
	{
		if ( !is_null($id) ) {
			$this->load($id);
		}
	}

	abstract public function load(int $id) : void;

	abstract public function save() : int;

	abstract protected function update() : int;

	abstract public function validate() : bool;

	/**
	 * Return an object by ID
	 * 
	 * @param int $id
	 * @return static|null
	 */
	public static function getById(int $id)
	{
		$class = get_called_class();

		$obj = new $class();
		$obj->load($id);

		if ( is_null($obj->id) ) {
			return null;
		}

		return $obj;
	}

}