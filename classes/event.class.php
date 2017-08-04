<?php

require_once "user.class.php";
require_once "database.class.php";

class Event {
	protected $key;
	protected $title;
	protected $date;
	protected $description;

	public $exist;

	function __construct($eventKey) {
		$database = new Database();
		$database->connect();

		$query = "SELECT * FROM events WHERE `key`=?";
		$statement = $database->prepare($query);
		$statement->bind_param("s", $eventKey);
		$statement->execute();
		$result = $statement->get_result();

		if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();

			$this->key = $row["key"];
			$this->title = $row["title"];
			$this->date = $row["date"];
			$this->description = $row["description"];

			$this->exist = true;
		} else {
			$this->exist = false;
		}
	}

	public function getKey() {
		return $this->key;
	}

	public function getTitle() {
		return $this->title;
	}

	public function getDate() {
		return $this->date;
	}

	public function getDescription() {
		return $this->description;
	}

	public function signIn(User $user) {
		$database = new Database();
		$database->connect();

		$query = "SELECT * FROM sign_up WHERE user_key=? AND event_key=? AND end_time IS NULL";
		$statement = $database->prepare($query);
		$statement->bind_param("ii", $user->getKey(), $this->key);
		$statement->execute();
		$result = $statement->get_result();

		if ($result->num_rows > 0) {
			return false; // Not signed out from last sign in.
		}

		$query = "INSERT INTO sign_up (user_key, event_key, start_time, end_time)
						VALUES (?, ?, NOW(), NULL)";
		$statement = $database->prepare($query);
		$statement->bind_param("ii", $user->getKey(), $this->key);
		$statement->execute();

		return true;
	}

	public function signOut(User $user) {
		$database = new Database();
		$database->connect();

		$query = "SELECT * FROM sign_up WHERE user_key=? AND event_key=? AND end_time IS NULL";
		$statement = $database->prepare($query);
		$statement->bind_param("ii", $user->getKey(), $this->key);
		$statement->execute();
		$result = $statement->get_result();

		if ($result->num_rows != 1) {
			return false; // Not signed in yet.
		}

		$query = "UPDATE sign_up SET end_time=NOW() WHERE end_time IS NULL";
		$database->query($query);

		return true;
	}
}

?>