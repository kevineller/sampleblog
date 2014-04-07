<?php

session_start();

if(isset($_SESSION['auth']) && $_SESSION['auth']) {
    mysql_connect("localhost", "root");
    mysql_select_db("sampleblog");

    $postID = intval($_POST['postID']);
    $content = mysql_real_escape_string($_POST['content']);

    mysql_query("INSERT INTO comments SET userID = '{$_SESSION['userID']}', postID = '$postID', content = '$content', addedAt = NOW()");

    if(mysql_insert_id() > 0) {
        echo "1";
    } else echo "0";

    mysql_close();
}