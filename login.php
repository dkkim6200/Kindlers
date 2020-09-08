<?php

require_once "includes/global.inc.php";

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
    header("Location: /volunteer_events.php");
}

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $database->connect();

    $query = "SELECT * FROM admin WHERE username=? AND password=?";
    $statement = $database->prepare($query);
    $statement->bind_param("ss", $_POST["username"], $_POST["password"]);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows == 1) {
        $_SESSION["logged_in"] = true;
        header("Location: /volunteer_events.php");
    }
    else {
        $errorMessage = "User does not exist";
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

        .form-login {
            max-width: 330px;
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
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/logout.php">Log out</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">

        <form class="form-login" action="/login.php" method="post">
            <h2 class="page-header">Log in</h2>

            <span class="error-message"><?php echo $errorMessage; ?></span>

            <div class="form-group">
                <input type="username" name="username" class="form-control" placeholder="Username" required autofocus>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button class="btn btn-lg btn-success btn-block" type="submit">Sign in</button>
        </form>

    </div><!-- /.container -->

</body>
</html>