<?php

// index.php

require_once "includes/global.inc.php";

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
	header("Location: /login.php");
}
else {
	header("Location: /volunteer_events.php");
}

?>