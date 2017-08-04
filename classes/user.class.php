<?php

require_once "database.class.php";

class User {
	protected $key;
	protected $firstName;
	protected $lastName;

	public $exist;

	function __construct($firstName, $lastName) {
		$database = new Database();
		$database->connect();

		$query = "SELECT * FROM users WHERE first_name=? AND last_name=?";
		$statement = $database->prepare($query);
		$statement->bind_param("ss", $firstName, $lastName);
		$statement->execute();
		$result = $statement->get_result();

		if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();

			$this->key = $row["key"];
			$this->firstName = $row["first_name"];
			$this->lastName = $row["last_name"];

			$this->exist = true;
		} else {
			$this->exist = false;
		}
	}

	public function getKey() {
		return $this->key;
	}

	public function getFirstName() {
		return $this->firstName;
	}

	public function getLastName() {
		return $this->lastName;
	}
}

?>