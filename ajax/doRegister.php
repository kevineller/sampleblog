<?php

header("Content-Type: application/json");

$username = mysql_real_escape_string($_POST['username']);
$password = mysql_real_escape_string($_POST['password']);

if(strlen($username) < 6 && strlen($username) > 20) {
    if(strlen($password) < 6 && strlen($password) > 20) {
        die(json_encode(array("error" => 2)));
    }
}

mysql_connect("localhost", "root");
mysql_select_db("sampleblog");

$result = mysql_query("SELECT * FROM users WHERE username = '$username'");

$outputData = array();

if(mysql_num_rows($result) < 1) { // Username is available
    $result = mysql_query("INSERT INTO users SET username = '$username', password = '$password'");
    if($newUserID = mysql_insert_id()) {
        $outputData['error'] = 0;
        $outputData['canPost'] = 0;

        //Start the session
        session_start();
        $_SESSION['auth'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['userID'] = $newUserID;
        $_SESSION['canPost'] = false;
        $_SESSION['avPath'] = "stockUser.png";

    } else $outputData['error'] = 3;
} else $outputData['error'] = 1;

echo(json_encode($outputData));