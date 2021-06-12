<?php

namespace DotanCohen\MatrixCustomers\Database;

use DotanCohen\PdoFactory\PdoFactory;

class CustomerPhoneNumber extends ActiveRecord {
	
	protected static $table = 'customer_phone_numbers';

	public $customer_id;
	public $phone_number;
	protected $phone_number_search;
	
	
	public function load(int $id) : void
	{
		$pdo = PdoFactory::getPdo();
		$table = self::$table;

		$sql = "SELECT customer_id, phone_number, phone_number_search";
		$sql.= " FROM {$table}";
		$sql.= " WHERE id=:id";
		$sql.= " LIMIT 1";

		$params = [
			':id' => $id,
		];
		
		$stmt = $pdo->prepare($sql);
		$stmt->execute($params);
		$row = $stmt->fetch(\PDO::FETCH_ASSOC);

		$this->id = $id;
		$this->customer_id = $row['customer_id'];
		$this->phone_number = $row['phone_number'];
		$this->phone_number_search = $row['phone_number_search'];
	}

	
	public function save() : CustomerPhoneNumber
	{
		$valid = $this->validate();
		// TODO
		
		$pdo = PdoFactory::getPdo();

		if ( !is_null($this->id) ) {

		}
		
		return 0;
	}
	
	
	protected function update() : CustomerPhoneNumber
	{
		// todo
		
		return 0;
	}
	
	
	public function validate() : bool
	{
		$this->validation_errors = [];

		// Ensure customer exists
		if ( Customer::getById($this->customer_id) ) {
			$this->validation_errors[] = 'Customer does not exist';
		}

		// Set phone_number_search
		$this->phone_number_search = self::getSearchString($this->phone_number);

		return empty($this->validation_errors);
	}


	public static function getSearchString($phone_number) : string
	{
		return preg_replace('/\D/', '', $phone_number);
	}


	public function toPublic() : string
	{
		return $this->phone_number;
	}


	public static function getByCustomer(int $customer_id) : array
	{
		// TODO
		
		return [1,2,3];
	}


}

/*
CREATE TABLE customer_phone_numbers (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NOT NULL,
  phone_number VARCHAR(127) NULL,
  phone_number_search BIGINT UNSIGNED NULL,
  INDEX (phone_number)
);
/* */
