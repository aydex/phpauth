<?php
/**
 * Created by PhpStorm.
 * User: Adrian
 * Date: 19.12.2015
 * Time: 01:24
 */

/** begin our session */
session_start();


/** first check that both the username, password and form token have been sent */
if (!isset( $_POST['username'], $_POST['password'], $_POST['form_token'])) {
    $message = 'Please enter a valid username and password';
}

/** check the form token is valid */
elseif( $_POST['form_token'] != $_SESSION['form_token']) {
    $message = 'Invalid form submission';
}

/** check that the username is the correct length */
elseif (strlen( $_POST['username']) > 20 || strlen($_POST['username']) < 4) {
    $message = 'Incorrect username length';
}

/** check that the password is the correct length */
elseif (strlen( $_POST['password']) > 20 || strlen( $_POST['password']) < 4) {
    $message = 'Incorrect passord length';
}

/** check that the username only has alphanumeric characters */
elseif (ctype_alnum($_POST['username']) != true) {
    $message = "Username must be alpha numeric";
}

/** check that the password only has alphanumeric characters */
elseif (ctype_alnum($_POST['password']) != true) {
    $message = "Password must be alpha numeric";
}
else {
    /** if we are here the data is valid and we can insert it into the database */
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    /** now we can encrypt the password */
    $password = sha1( $password );

    /** connect to database */
    /** mysql hostname */
    $mysql_hostname = 'mysql.stud.ntnu.no';

    /** mysql username */
    $mysql_username = 'adrianah';

    /** mysql password */
    $mysql_password = 'AdrianH1';

    /** database name */
    $mysql_dbname = 'adrianah_users';

    try {
        $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
        /** $message =  a message saying we have connected */

        /** set the error mode to exceptions */
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /** prepare the insert */
        $stmt = $dbh->prepare("INSERT INTO users (username, password ) VALUES (:username, :password)");

        /** bind the parameters */
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 40);

        /** execute the prepared staement */
        $stmt->execute();

        /** unset the form token session variable */
        unset( $_SESSION['form_token'] );

        /** if all is done, say thanks */
        $message = 'New user added';
    } catch(Exception $e) {
        /** check if the username already exists */
        if( $e->getCode() == 23000) {
            $message = 'Username already exists';
        } else {
            /** if we are here, something has gone wrong with the database */
            $message = 'We are unable to process the request. Please try again later.';
        }
    }
}
?>

<html>
<head>
    <title>folk.ntnu.no/adrianah - add user</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css"/>
</head>
<body>
<p>
    <?php echo $message; ?>
</p>
</body>
</html>
