<?php

namespace DotanCohen\MatrixCustomers\Database;

use DotanCohen\PdoFactory\PdoFactory;

class CustomerPhoneNumber extends ActiveRecord {
	
	protected static $table = 'customer_phone_numbers';

	public int $customer_id;
	public string $phone_number;
	protected string $phone_number_search;
	
	
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

		// If id does not exist then explicitly set $this->id to null and return
		if ( !$row ) {
			$this->id = null;
			return;
		}

		$this->id = $id;
		$this->customer_id = $row['customer_id'];
		$this->phone_number = $row['phone_number'];
		$this->phone_number_search = $row['phone_number_search'];
	}

	
	public function save() : CustomerPhoneNumber
	{
		// TODO

		if ( !$this->validate() ) {
			throw new \Exception("Invalid object");
		}

		if ( !is_null($this->id) ) {
			return $this->update();
		}

		$pdo = PdoFactory::getPdo();
		$table = self::$table;


		$sql = "INSERT INTO {$table} (customer_id, phone_number, phone_number_search)";
		$sql.= " VALUES (:customer_id, :phone_number, :phone_number_search)";

		$params = [
			':customer_id' => $this->customer_id,
			':phone_number' => $this->phone_number,
			':phone_number_search' => $this->phone_number_search, // Set during validation
		];

		$stmt = $pdo->prepare($sql);
		$stmt->execute($params);
		$this->id = $pdo->lastInsertId();

		// TODO check saved

		return self::getById($this->id);
	}
	
	
	protected function update() : CustomerPhoneNumber
	{
		// todo
		
		return self::getById($this->id);
	}
	
	
	public function validate() : bool
	{
		$this->validation_errors = [];

		// Ensure customer exists
		if ( !Customer::getById($this->customer_id) ) {
			$this->validation_errors[] = "Customer `{$this->customer_id}` does not exist";
		}

		// Set phone_number_search
		$this->phone_number_search = self::getSearchString($this->phone_number);

		return empty($this->validation_errors);
	}


	public static function getSearchString(string $phone_number) : string
	{
		return preg_replace('/\D/', '', $phone_number);
	}


	public function toPublic() : string
	{
		return $this->phone_number;
	}


	/**
	 * Return an array of phone numbers for a specific customer
	 *
	 * @param int $customer_id
	 * @return CustomerPhoneNumber[]
	 * @throws \Exception
	 */
	public static function getByCustomer(int $customer_id) : array
	{
		$pdo = PdoFactory::getPdo();
		$table = self::$table;
		$phone_numbers = [];

		$sql = "SELECT id";
		$sql.= " FROM {$table}";
		$sql.= " WHERE customer_id=:customer_id";

		$params = [
			':customer_id' => $customer_id,
		];

		$stmt = $pdo->prepare($sql);
		$stmt->execute($params);
		while ( $row = $stmt->fetch(\PDO::FETCH_ASSOC) ) {
			// Despite requiring multiple queries, this ensures consistency in the output
			$phone_numbers[] = self::getById($row['id']);
		}

		return $phone_numbers;
	}


	/**
	 * Return an array of phone numbers matching a search string
	 *
	 * @param string $search
	 * @return CustomerPhoneNumber[]
	 * @throws \Exception
	 */
	public static function getBySearch(string $search) : array
	{
		$pdo = PdoFactory::getPdo();
		$table = self::$table;
		$phone_numbers = [];

		$sql = "SELECT id";
		$sql.= " FROM {$table}";
		$sql.= " WHERE phone_number_search LIKE :phone";

		$params = [
			':phone' => self::getSearchString($search),
		];

		$stmt = $pdo->prepare($sql);
		$stmt->execute($params);
		while ( $row = $stmt->fetch(\PDO::FETCH_ASSOC) ) {
			// Despite requiring multiple queries, this ensures consistency in the output
			$phone_numbers[] = self::getById($row['id']);
		}

		return $phone_numbers;
	}


	/**
	 * Delete a phone number
	 *
	 * @param int $id
	 * @throws \Exception
	 */
	public static function deleteByID(int $id) : void
	{
		$pdo = PdoFactory::getPdo();
		$table = self::$table;

		$sql = "DELETE";
		$sql.= " FROM {$table}";
		$sql.= " WHERE id=:id";

		$params = [
			':id' => $id,
		];

		$stmt = $pdo->prepare($sql);

		$stmt->execute($params);
	}


	/**
	 * Delete all phone numbers for a specific customer
	 *
	 * @param int $customer_id
	 * @param \PDO|null $pdo Optional PDO object to enable transactions
	 * @throws \Exception
	 */
	public static function deleteByCustomer(int $customer_id, ?\PDO $pdo=null) : void
	{
		if ( !$pdo ) {
			$pdo = PdoFactory::getPdo();
		}

		$table = self::$table;

		$sql = "DELETE";
		$sql.= " FROM {$table}";
		$sql.= " WHERE customer_id=:customer_id";

		$params = [
			':customer_id' => $customer_id,
		];

		$stmt = $pdo->prepare($sql);
		$stmt->execute($params);
	}

}

/*
CREATE TABLE customer_phone_numbers (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NOT NULL,
  phone_number VARCHAR(127) NULL,
  phone_number_search VARCHAR(127) NULL,
  INDEX (phone_number)
);
/* */
