<?php

class Database {
	protected $host;
	protected $username;
	protected $password;
	protected $schema;

	protected $conn;

	function __construct() {
		$this->host = "127.0.0.1";
		$this->username = "root";
		$this->password = "David620";
		$this->schema = "kindlers";

		$this->conn = NULL;
	}

	public function connect() {
		$this->conn = new mysqli($this->host, $this->username, $this->password, $this->schema);

		if ($this->conn->connect_error) {
			return false;
		} else {
			return true;
		}
	}

	public function query($statement) {
		$result = $this->conn->query($statement);

		return $result;
	}

	public function prepare($query) {
		$statement = $this->conn->prepare($query);

		return $statement;
	}
}

?>