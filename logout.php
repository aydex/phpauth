<?php
/**
 * Created by PhpStorm.
 * User: Adrian
 * Date: 19.12.2015
 * Time: 02:49
 */

/** begin the session */
session_start();

/** unset all the session variables */
session_unset();

/** destroy the session */
session_destroy();
?>
<html>
<head>
    <title>folk.ntnu.no/adrianah - Logged out</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css"/>
</head>
<body>
<h1>You are now logged out. Please come again</h1>
<p><a class="myButton" href="index.php">Home</a></p>
</body>
</html>
