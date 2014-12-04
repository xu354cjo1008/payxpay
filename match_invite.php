<?php
        if(isset($_POST['match_invite'])) {
            $match_invite = $_POST ['match_invite'];
            $dbhost = '127.0.0.1';
            $dbuser = 'root';
            $dbpass = '';
            $dbname = 'partnera';
            $con = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection'); 
            mysqli_query($con,"set names 'UTF8' ");
            mysqli_select_db($con,$dbname);
            session_start(); 
            //寄邀請信給每個被邀請的人
            foreach ($match_invite as $value)
            {
              $invite=  mysqli_real_escape_string($con,$value);
              $sql = "INSERT INTO invite_message (sendto,sender,content) VALUES ('".$invite."','".$_SESSION['id']."',0)";
              mysqli_query($con,$sql) or die(mysqli_error($con));
            }
            //寄邀請信給每個隊友
            $sql = "SELECT * FROM user_info WHERE user_host ='".$_SESSION['id']."' AND id <> '".$_SESSION['id']."'";
            $res = mysqli_query($con,$sql) or die(mysqli_error($con));  
            while($record = mysqli_fetch_array($res)){
                $sql = "INSERT INTO invite_message (sendto,sender,content) VALUES ('".$record['id']."','".$_SESSION['id']."',3)";
                mysqli_query($con,$sql) or die(mysqli_error($con));
            }
            mysqli_close($con);
            die();
        }
       // echo json_encode(1);
?>
