<?php

require_once "includes/global.inc.php";

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
    header("Location: /login.php");
}

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $database->connect();

    $query = "INSERT INTO events (`title`, `date`, `description`) VALUES (?, ?, ?)";
    $statement = $database->prepare($query);
    $statement->bind_param("sss", $_POST["title"], $_POST["date"], $_POST["description"]);
    $statement->execute();

    $query = "SELECT * FROM events WHERE `title`=? AND `date`=? AND `description`=?";
    $statement = $database->prepare($query);
    $statement->bind_param("sss", $_POST["title"], $_POST["date"], $_POST["description"]);
    $statement->execute();
    $result = $statement->get_result();

    $row = $result->fetch_assoc();
    header("Location: /event.php?key=" . $row["key"]);
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

    <link rel="stylesheet" href="/assets/bootstrap-datepicker/css/bootstrap-datepicker3.standalone.css" />
    <script src="/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

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

        .error-message {
            color: red;
        }
    </style>

    <script type="text/javascript">
        $('.datepicker').datepicker();
    </script>

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
                    <li class="active"><a href="/create_event.php">Create Event</a></li>
                    <li><a href="/volunteer_hours.php">Check My Volunteer Hours</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/logout.php">Log out</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container body">
		<h2 class="page-header">Create Event</h2>
		<div class="content">
			<span class="error-message"><?php echo $errorMessage; ?></span>
	        <form class="form-sign-up" action="/create_event.php" method="post">
	        	<div class="form-group">
                    <label for="title">Title</label>
	        		<input name="title" class="form-control" placeholder="Enter title" required autofocus>
	            </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <div class="input-group date" data-provide="datepicker" data-date-orientation="bottom auto" data-date-format="yyyy-mm-dd">
                        <input name="date" type="text" class="form-control">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" row="5" placeholder="Enter description"></textarea>
                </div>
                <button class="btn btn-lg btn-success" type="submit">Create</button>
	        </form>
        </div>
    </div><!-- /.container -->

</body>
</html>