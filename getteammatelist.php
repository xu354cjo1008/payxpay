<?php
        $dbhost = '127.0.0.1';
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'partnera';
        $con = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection'); 
        mysqli_query($con,"set names 'UTF8' ");
        mysqli_select_db($con,$dbname);
        session_start();  
        $sql = "SELECT * FROM user_info WHERE id ='".$_SESSION['user_host']."'";
        $res = mysqli_query($con,$sql) or die(mysqli_error($con));  
        $teammate=array();
        $rows = mysqli_fetch_assoc($res);
        $teammate[]=array($rows['id'],$rows['user_name']);
        $sql = "SELECT * FROM user_info WHERE user_host ='".$_SESSION['user_host']."'";
        $res = mysqli_query($con,$sql) or die(mysqli_error($con));
        while($record = mysqli_fetch_array($res)){
            if($record['id']!=$teammate[0][0])
               $teammate[]=array($record['id'],$record['user_name']);
        }
        $sql = "DELETE FROM invite_message WHERE sendto = '".$_SESSION['id']."' AND content IN (1,2,3,4,5)";
        mysqli_query($con,$sql) or die(mysqli_error($con));
        session_write_close();
        mysqli_close($con);
        echo json_encode($teammate);
?>
