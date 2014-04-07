<?php

mysql_connect("localhost", "root");
mysql_select_db("sampleblog");

$username = mysql_real_escape_string($_POST['username']);
$password = mysql_real_escape_string($_POST['password']);

$result = mysql_query("SELECT u.id, u.canPost, u.avPath FROM users u WHERE username = '$username' AND password = '$password' LIMIT 1");

$outputData = array();

if(mysql_num_rows($result) > 0) { //There was a valid login.
    $row = mysql_fetch_assoc($result);

    //Prep return data
    $outputData['error'] = 0;
    $outputData['canPost'] = intval($row['canPost']);

    //Start the session
    session_start();
    $_SESSION['auth'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['userID'] = intval($row['id']);
    $_SESSION['canPost'] = (bool)intval($row['canPost']);
    $_SESSION['avPath'] = $row['avPath'];

} else { //No valid login was found
    $outputData['error'] = 1;
}

header('Content-Type: application/json');
echo(json_encode($outputData));