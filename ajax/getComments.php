<?php

$postID = intval($_GET['postID']);

mysql_connect("localhost", "root");
mysql_select_db("sampleblog");

$result = mysql_query("SELECT co.*, u.username, u.avPath FROM Comments co LEFT JOIN Users u ON co.userID = u.id WHERE co.postID = '$postID' ORDER BY co.addedAt ASC");

if(mysql_num_rows($result) > 0) {
    $outputData = array();

    while($row = mysql_fetch_assoc($result)) {
        $outputData[] = $row;
    }

    header('Content-Type: application/json');
    echo(json_encode($outputData));
}