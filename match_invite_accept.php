<?php
        $dbhost = '127.0.0.1';
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'partnera';
        $con = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection'); 
        mysqli_query($con,"set names 'UTF8' ");
        mysqli_select_db($con,$dbname);
        session_start();
        //發給房間所有人確認信        
        $sql = "SELECT * FROM user_info WHERE user_host ='".$_POST['program_type']."'";
        $res=mysqli_query($con,$sql) or die(mysqli_error($con)); 
        while($record = mysqli_fetch_array($res)){   
            $sql = "INSERT INTO invite_message (sendto,sender,content) VALUES ('".$record['id']."','".$_SESSION['id']."',1)";
            mysqli_query($con,$sql) or die(mysqli_error($con));
         }
         //更新使用者資訊
        $sql = "UPDATE user_info SET user_state = '1' WHERE id= '".$_SESSION['id']."'";
        mysqli_query($con,$sql) or die(mysqli_error($con));
        $sql = "UPDATE user_info SET user_host = '".$_POST['program_type']."' WHERE id= '".$_SESSION['id']."'";
        mysqli_query($con,$sql) or die(mysqli_error($con));
        //刪除邀請信
        $sql = "DELETE FROM invite_message WHERE sendto = '".$_SESSION['id']."' AND sender='".$_POST['program_type']."' ";
        mysqli_query($con,$sql) or die(mysqli_error($con));
        mysqli_close($con);
        session_write_close();
        header("location:match.php");
//        echo json_encode(1);
?>
