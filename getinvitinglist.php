<?php
        $dbhost = '127.0.0.1';
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'partnera';
        $con = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection'); 
        mysqli_query($con,"set names 'UTF8' ");
        mysqli_select_db($con,$dbname);
        session_start();  
        $sql = "SELECT * FROM invite_message WHERE sender ='".$_SESSION['user_host']."' AND content=0 ";
        $res = mysqli_query($con,$sql) or die(mysqli_error($con));
        $invitinglist=array();
        while($record = mysqli_fetch_array($res)){
           $sql = "SELECT * FROM user_info WHERE id ='".$record['sendto']."'";
           $res2 = mysqli_query($con,$sql) or die(mysqli_error($con));
           $record2 = mysqli_fetch_assoc($res2);
           $invitinglist[]=array($record2['id'],$record2['user_name'],$record['datatime']);
        }
        $sql = "DELETE FROM invite_message WHERE sendto = '".$_SESSION['id']."' AND content IN (1,2,3,4,5)";
        mysqli_query($con,$sql) or die(mysqli_error($con));
        session_write_close();
        mysqli_close($con);
        echo json_encode($invitinglist);
?>
