<?php

session_start();

if(isset($_SESSION['auth']) && $_SESSION['auth'] && $_SESSION['canPost']) {
    mysql_connect("localhost", "root");
    mysql_select_db("sampleblog");

    $title = mysql_real_escape_string($_POST['title']);
    $content = mysql_real_escape_string($_POST['content']);

    //When in a double quoted string ("") you can use direct links to variables (like $title, $content below) AND you can link to array elements using {$array['elem']}
    mysql_query("INSERT INTO posts SET userID = '{$_SESSION['userID']}', title = '$title', content = '$content', addedAt = NOW()");

    if(mysql_insert_id() > 0) {
        echo "1";
    } else echo "0";

    mysql_close();
}