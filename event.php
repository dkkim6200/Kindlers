<?php

require_once "includes/global.inc.php";

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
    header("Location: /login.php");
}

$errorMessage = "";
$eventKey = $_GET["key"];

$event = new Event($eventKey);
if (!$event->exist) {
	header("Location: /volunteer_events.php");
}

$eventTitle = $event->getTitle();
$eventDate = $event->getDate();
$eventDescription = $event->getDescription();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User($_POST["first-name"], $_POST["last-name"]);
	if (!$user->exist) {
		$errorMessage = "This member does not exist.";
	}
	
    if (isset($_POST["sign-in"])) {
    	if (!$event->signIn($user)) {
    		$errorMessage = "Please sign out from your last sign up.";
    	}
    }
    else if (isset($_POST["sign-out"])) {
    	if (!$event->signOut($user)) {
    		$errorMessage = "Please sign in first.";
    	}
    }
}

?>


<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>REMSS Kindlers Volunteer Hour Management System</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


    <!-- =========== CSS =========== -->
    <style type="text/css">
        body {
            padding-top: 50px;
        }

        hr {
        	width: 60%;
        }

        .body {
            max-width: 800px;
            margin: 0 auto;
        }

        .content {
        	max-width: 600px;
            margin: 0 auto;
        }

        .form-sign-up {
        	max-width: 330px;
        }

        .error-message {
            color: red;
        }
    </style>

</head>

<body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">REMSS Kindlers</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/volunteer_events.php">Volunteer Events</a></li>
                    <li><a href="/create_event.php">Create Event</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/logout.php">Log out</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container body">
		<h2 class="page-header"><?php echo $eventTitle ?></h2>
		<div class="content">
			<label>Date</label>
			<p><?php echo $eventDate ?></p>

			<label>Description</label>
			<p><?php echo $eventDescription ?></p>

			<hr>

			<span class="error-message"><?php echo $errorMessage; ?></span>
	        <form class="form-sign-up" action="/event.php?key=<?php echo $_GET["key"] ?>" method="post">
	        	<div class="form-group">
	        		<input name="first-name" class="form-control" placeholder="First name" required autofocus>
	            	<input name="last-name" class="form-control" placeholder="Last name" required>
	            </div>

	            <button name="sign-in" class="btn btn-lg btn-success" type="submit">Sign in</button>
	            <button name="sign-out" class="btn btn-lg btn-danger" type="submit">Sign out</button>
	        </form>
        </div>
    </div><!-- /.container -->

</body>
</html>