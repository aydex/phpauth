<?php
/**
 * Created by PhpStorm.
 * User: Adrian
 * Date: 19.12.2015
 * Time: 02:27
 */

/** begin the session */
session_start();

if(!isset($_SESSION['user_id'])) {
    $message = "You must be logged in to access this page";
} else {
    try {
        /** connect to database */
        /** mysql hostname */
        $mysql_hostname = 'mysql.stud.ntnu.no';

        /** mysql username */
        $mysql_username = 'adrianah';

        /** mysql password */
        $mysql_password = 'AdrianH1';

        /** database name */
        $mysql_dbname = 'adrianah_users';

        /** select the users name from the database ***/
        $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
        /** $message = a message saying we have connected ***/

        /*** set the error mode to excptions ***/
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /** prepare the select */
        $stmt = $dbh->prepare("SELECT username FROM users WHERE user_id = :user_id");

        /** bind the parameters */
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

        /** execute the prepared statement */
        $stmt->execute();

        /** check for a result */
        $username = $stmt->fetchColumn();

        /** if we have no username, something is wrong */
        if($username == false) {
            $message = 'Access Error';
        } else {
            $message = 'Welcome '.$username;
        }
    } catch (Exception $e) {
        /** if we are here, something went wrong in the database */
        $message = "We were unable to process your request. Please try again later";
    }
}
?>

<html>
<head>
    <title>folk.ntnu.no/adrianah - member</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css"/>
</head>
<body>
<h2><?php echo $message; ?></h2>
</body>
</html>
