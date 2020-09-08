<?php

require_once "includes/global.inc.php";

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
    header("Location: /login.php");
}

$errorMessage = "";
$volunteerEventsList = "";

$database = new Database();
$database->connect();

$query = "SELECT * FROM events ORDER BY `date` DESC";
$result = $database->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
    	$volunteerEventsList = $volunteerEventsList . "<tr>" .
    							"<td><a href='/event.php?key=" . $row["key"] . "'>" . $row["title"] . "</a></td>" .
    							"<td>" . $row["date"] . "</td>" .
    							"</tr>";
    }
}
else {
    $volunteerEventsList = "<tr><td>No events</td></tr>";
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
                    <li class="active"><a href="/volunteer_events.php">Volunteer Events</a></li>
                    <li><a href="/create_event.php">Create Event</a></li>
                    <li><a href="/volunteer_hours.php">Check My Volunteer Hours</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/logout.php">Log out</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container body">
		<h2 class="page-header">Volunteer Events</h2>
        <div class="content">
    		<span class="error-message"><?php echo $errorMessage; ?></span>
            <table class="table">
            	<thead>
            		<tr>
            			<th>Title</th>
            			<th>Date</th>
            		</tr>
            	</thead>
            	<tbody>
            		<?php echo $volunteerEventsList ?>
            	</tbody>
            </table>
        </div>
    </div><!-- /.container -->

</body>
</html>