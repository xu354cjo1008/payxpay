<?php
        $dbhost = '127.0.0.1';
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'partnera';
        $con = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection'); 
        mysqli_query($con,"set names 'UTF8' ");
        mysqli_select_db($con,$dbname);
        session_start();
        $sql = "DELETE FROM invite_message WHERE sender = '".$_POST['delete_id']."' AND sendto ='".$_SESSION['id']."'";
        mysqli_query($con,$sql) or die(mysqli_error($con));
        $sql = "SELECT * FROM user_info WHERE user_host ='".$_POST['delete_id']."'";
        $res=mysqli_query($con,$sql) or die(mysqli_error($con)); 
        while($record = mysqli_fetch_array($res)){   
            $sql = "INSERT INTO invite_message (sendto,sender,content) VALUES ('".$record['id']."','".$_SESSION['id']."',2)";
            mysqli_query($con,$sql) or die(mysqli_error($con));
        }
        echo "1";
        
?>
