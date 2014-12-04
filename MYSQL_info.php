<?php

    $url=parse_url(getenv("CLEARDB_DATABASE_URL"));

    $dbhost = 'us-cdbr-iron-east-01.cleardb.net'//$url["host"];
    $dbuser = 'bae9e968e129dc'//$url["user"];
    $dbpass = 'e47e9189'//$url["pass"];
    $dbname = 'heroku_3ae224a4e4a2b87'//substr($url["path"],1);

    mysqli_connect($dbhost, $dbuser, $dbpass);


    mysqli_select_db($dbname);
?>
