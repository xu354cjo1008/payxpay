<?php
session_start();
 if($_SESSION['user_state']=='0'){
            $dbhost = '127.0.0.1';
            $dbuser = 'root';
            $dbpass = '';
            $dbname = 'partnera';
            $con = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');      
            mysqli_query($con,"SET NAMES 'utf8'");
            mysqli_select_db($con,$dbname);
            $sql = "UPDATE user_info SET user_host = '".$_SESSION['id']."' WHERE id = '".$_SESSION['id']."' ";
            mysqli_query($con,$sql) or die(mysqli_error($con));
            $sql = "UPDATE user_info SET user_state = '1' WHERE id = '".$_SESSION['id']."'";
            mysqli_query($con,$sql) or die(mysqli_error($con));
            mysqli_close($con);
            session_write_close();
            header("location:match.php");  
 }
?>
