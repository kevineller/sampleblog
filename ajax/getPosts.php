<?php

mysql_connect("localhost", "root");
mysql_select_db("sampleblog");

$result = mysql_query("SELECT p.*, u.username, u.avPath FROM Posts p LEFT JOIN Users u ON p.userID = u.id ORDER BY addedAt DESC");

if(mysql_num_rows($result) > 0) {
    $outputData = array();

    while($row = mysql_fetch_assoc($result)) {
        $outputData[] = $row;
    }

    header('Content-Type: application/json');
    echo(json_encode($outputData));
}

mysql_close();