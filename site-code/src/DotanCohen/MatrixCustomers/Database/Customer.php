<?php

namespace DotanCohen\MatrixCustomers\Database;

use DotanCohen\PdoFactory\PdoFactory;

class Customer extends ActiveRecord {
	
	protected static $table = 'customers';

	public string $id_gov;
	public string $name_first;
	public string $name_last;
	public \DateTime $date_birth;
	public string $sex;
	public array $phones;
	
	protected static $sex_values_valid = ['male', 'female', 'other'];


	public function load(int $id) : void
	{
		$pdo = PdoFactory::getPdo();
		$table = self::$table;

		$sql = "SELECT id_gov, name_first, name_last, date_birth, sex";
		$sql.= " FROM {$table}";
		$sql.= " WHERE id=:id";
		$sql.= " LIMIT 1";
		
		$params = [
			':id' => $id,
		];

		$stmt = $pdo->prepare($sql);
		$row = $stmt->execute($params)->fetch(\PDO::FETCH_ASSOC);
		
		// TODO
		// If id does not exist then explicitly set $this->id to null and return
		// Also set in phone numbers table
		if ( is_null($row) ) { // Maybe change condition
			$this->id = null;
			return;
		}

		$this->id = $id;
		$this->id_gov = $row['id_gov'];
		$this->name_first = $row['name_first'];
		$this->name_last = $row['name_last'];
		$this->date_birth = new \DateTime($row['date_birth']);
		$this->sex = $row['sex'];

		$this->phones = CustomerPhoneNumber::getByCustomer($id);
	}

	
	public function save() : int
	{
		if ( !$this->validate() ) {
			throw new \Exception("Invalid object");
		}

		if ( !is_null($this->id) ) {
			return $this->update();
		}

		$pdo = PdoFactory::getPdo();
		$table = self::$table;


		$sql = "INSERT INTO {$table} (id_gov, name_first, name_last, date_birth, sex)";
		$sql.= " VALUES (:id_gov, :name_first, :name_last, :date_birth, :sex)";

		$params = [
			':id_gov' => $this->id_gov,
			':name_first' => $this->name_first,
			':name_last' => $this->name_last,
			':date_birth' => $this->date_birth->format(self::MYSQL_DATETIME),
			':sex' => $this->sex,
		];

		$stmt = $pdo->prepare($sql);
		$row = $stmt->execute($params);

		// TODO check saved

		$current_phones = CustomerPhoneNumber::getByCustomer($this->id);
		foreach ($this->phones as $phone) {
			$k = array_search($phone, $current_phones);
			if ( $k === false ) {
				// TODO Add phone number to client
			} else{
				unset($current_phones[$k]);
			}
		}

		foreach ($current_phones as $current_phone) {
			// todo remove phone from client
		}

		return $pdo->lastInsertId();
	}


	protected function update() : int
	{
		// todo

		return 0;
	}


	public function validate() : bool
	{
		$this->validation_errors = [];

		if ( !in_array($this->sex, self::$sex_values_valid)) {
			$this->validation_errors[] = 'Field `sex` must be one of the following values: ' . implode(',', self::$sex_values_valid);
		}

		return empty($this->validation_errors);
	}


	public function getByPhone($id) : array
	{
		// TODO
		
		return [];
	}

}

/*
CREATE TABLE customers (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_gov VARCHAR(127) NULL,
  name_first VARCHAR(127) NULL,
  name_last VARCHAR(127) NULL,
  date_birth DATE NULL,
  sex ENUM('male', 'female', 'other') NULL,
  INDEX (id_gov)
);
/* */