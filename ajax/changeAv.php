<?php

session_start();

if($_SESSION['auth']) {

    mysql_connect("localhost", "root");
    mysql_select_db("sampleblog");

    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);
    if ((($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/pjpeg")
            || ($_FILES["file"]["type"] == "image/x-png")
            || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 15242880)
        && in_array($extension, $allowedExts))
    {
        if ($_FILES["file"]["error"] > 0)
        {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
        }
        else
        {
            echo "Upload: " . $_FILES["file"]["name"] . "<br>";
            echo "Type: " . $_FILES["file"]["type"] . "<br>";
            echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
            echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";


            $avPathQ = "av" . microtime() . $_FILES["file"]["name"];
            $avPath = "../upload/" .$avPathQ;

            if (file_exists($avPath))
            {
                echo $_FILES["file"]["name"] . " already exists. ";
            }
            else
            {
                move_uploaded_file($_FILES["file"]["tmp_name"],
                    $avPath);
                echo "Success!";

                mysql_connect("localhost", "root");
                mysql_select_db("sampleblog");


                $result = mysql_query("UPDATE users SET avPath = '$avPathQ'");

                if(!$result) {
                    echo "DB Success.";
                }

                header('Location: ../settings.php');
            }
        }
    }
    else echo "Invalid file";
} else echo "Not authorized";