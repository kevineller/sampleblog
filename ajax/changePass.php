<?php
header("Content-Type: application/json");

session_start();
$userID = $_SESSION['userID'];

if(!$_SESSION['auth']) {
    die(json_encode(array("error" => 1))); // Not authorized
}

$pass = mysql_real_escape_string($_POST['pass']);
$newPass = mysql_real_escape_string($_POST['newPass']);

if(strlen($pass) < 6 && strlen($pass) > 20) {
    die(json_encode(array("error" => 2))); // Invalid password length.
}

mysql_connect("localhost", "root");
mysql_select_db("sampleblog");

$result = mysql_query("SELECT u.id, u.password FROM users u WHERE id = '$userID' AND password = '$pass'");
$outputData = array();

if(mysql_num_rows($result) > 0) { //Valid user info
    $uResult = mysql_query("UPDATE users SET password = '$newPass' WHERE id = '$userID'");
    if($uResult) {
        $outputData['error'] = 0; //Success
    } else $outputData['error'] = 4; //Database error
} else $outputData['error'] = 3;

echo(json_encode($outputData));