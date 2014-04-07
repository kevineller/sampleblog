<?php

function getAvatarURL($userID = null) {
    if(is_null($userID)) {
        $userID = $_SESSION['userID'];
    }

    $userID = intval($userID);

    mysql_connect("localhost", "root");
    mysql_select_db("sampleblog");

    $result = mysql_query("SELECT avPath from users WHERE id = '$userID'");

    if(mysql_num_rows($result) > 0) {
        $row = mysql_fetch_assoc($result);
        return $row['avPath'];
    }

    return null;
}