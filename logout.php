<?php

require_once "includes/global.inc.php";

$_SESSION["logged_in"] = false;
header("Location: /login.php");

?>