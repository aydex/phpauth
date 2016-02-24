<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>folk.ntnu.no/adrianah - login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css"/>
</head>
<body>
<?php /**if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
};*/
session_start();
if( !isset($_SESSION['user_id'])):?>
<h2>Login here</h2>
<form action="login_submit.php" method="post">
    <fieldset>
        <p>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="" maxlength="20"/>
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="" maxlength="20"/>
        </p>
        <p>
            <input type="submit" class="myButton" value="Login"/>
        </p>
    </fieldset>
</form>
<?php else: ?>
<h2>Logout Here</h2>
    <br>
<p><a class="myButton" href="logout.php">Log out</a></p>
<?php endif; ?>
</body>
</html>