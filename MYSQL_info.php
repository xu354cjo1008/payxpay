<?php

    $url=parse_url(getenv("CLEARDB_DATABASE_URL"));
    $server = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $dbhost = substr($url["path"],1);

    mysqli_connect($server, $username, $password);


    mysqli_select_db($dbhost);
?>
