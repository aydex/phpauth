<?php
/**
 * Created by PhpStorm.
 * User: Adrian
 * Date: 19.12.2015
 * Time: 01:11
 */

/** begin our session */
session_start();

/** set a form token */
$form_token = md5( uniqid('auth', true) );

/** the session form token */
$_SESSION['form_token'] = $form_token;
?>

<html>
<head>
    <title>folk.ntnu.no/adrianah - add user</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css"/>
</head>

<body>
<h2>Add user</h2>
<form action="adduser_submit.php" method="post">
    <fieldset>
        <p>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="" maxlength="20" />
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="" maxlength="20"/>
        </p>
        <p>
            <input type="hidden" name="form_token" value="<?php echo $form_token; ?>"/>
            <input type="submit" class="myButton" value="&rarr; Add User" />
        </p>
    </fieldset>
</form>
</body>
</html>