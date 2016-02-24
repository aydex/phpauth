<?php
/**
 * Created by PhpStorm.
 * User: Adrian
 * Date: 19.12.2015
 * Time: 01:54
 */

/** begin our session */
session_start();

/** check if the user is already logged in */
if(isset($_SESSION['user_id'])) {
    $message = 'User is already logged in';
}

/** check that both the username and password have been submitted */
if(!isset($_POST['username'], $_POST['password'])) {
    $message = 'Please enter a valid username and password';
}

/** check that the username is the correct length */
elseif(strlen($_POST['username']) > 20 || strlen($_POST['username']) < 4) {
        $message = 'Incorrect username length';
}

/** check that the password is the correct length */
elseif(strlen($_POST['password']) > 20 || strlen($_POST['password']) < 4) {
    $message = 'Incorrect password length';
}

/** check that the username only has alpha numeric characters ***/
elseif (ctype_alnum($_POST['username']) != true)
{
    $message = "Username must be alpha numeric";
}

/*** check that the password only has alpha numeric characters ***/
elseif (ctype_alnum($_POST['password']) != true)
{
    $message = "Password must be alpha numeric";
} else {
    /** if we are here the data is valid and we can send it to the database */
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    /** now we can encrypt the password */
    $password = sha1($password);

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
        /** $message = a message saying we have connected */

        /** set the error mode to exceptions */
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /** prepare the select statement */
        $stmt = $dbh->prepare("SELECT user_id, username, password FROM users
                              WHERE username=:username AND password=:password");

        /** bind the parameters */
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 40);

        /** execute the prepared statement */
        $stmt->execute();

        /** check for a result */
        $user_id = $stmt->fetchColumn();

        /** if we have no result then fail boat */
        if($user_id == false) {
            $message = "Login Failed";
        }

        /** if we do have a result, all is well */
        else {
            $_SESSION['user_id'] = $user_id;

            /** tell the user we are logged in */
            $message = "You are now logged in";
        }
    } catch (Exception $e) {
        /** if we are here, something has gone wrong with the database */
        $message = "We were unable to process your request. Please try again later";
    }
}
?>

<html>
<head>
    <title>folk.ntnu.no/adrianah - login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css"/>
</head>
<body>
<p>
    <?php
    echo $message;
    if (isset($_SESSION['user_id'])):
        header('Refresh: 3; URL=http://folk.ntnu.no/adrianah/phpauth/members.php');
    ?>
</p>
<p>
    You will be redirected, if not, click <a href="members.php">here.</a>
</p>
<?php endif; ?>
</body>
</html>
