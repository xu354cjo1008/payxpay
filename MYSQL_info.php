<?php

    $url=parse_url(getenv("CLEARDB_DATABASE_URL"));

    $dbhost = $url["host"];
    $dbuser = $url["user"];
    $dbpass = $url["pass"];
    $dbname = substr($url["path"],1);

    //mysqli_connect($dbhost, $dbuser, $dbpass);


    //mysqli_select_db($dbname);
?>
