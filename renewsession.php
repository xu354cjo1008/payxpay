<?php

            $dbhost = '127.0.0.1';
            $dbuser = 'root';
            $dbpass = '';
            $dbname = 'partnera';
            $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
            session_start();
            if($conn){
                mysql_query("SET NAMES 'utf8'");
                mysql_select_db($dbname);
                $query = "SELECT * FROM user_info WHERE id ='".$_SESSION['id']."'";
                $res=mysql_query($query,$conn) or die(mysql_error());
                $rows = mysql_fetch_assoc($res);
                $_SESSION['user_state'] = $rows['user_state'];
                $_SESSION['user_host'] = $rows['user_host'];
                mysql_close($conn);               
            }else{
             echo "damn";
            }
?>
