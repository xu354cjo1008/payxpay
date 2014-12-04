<?php
 include_once("logdata.php");
 //sql連線
 session_start();
           $con = mysqli_connect($dbhost, $dbuser, $dbpass);
            mysqli_query($con,"SET NAMES 'utf8'");
              mysqli_select_db($con,$dbname);
              //查詢房間id
           // $name=$_SESSION['username'];
           // $sql = "SELECT * FROM user WHERE id ='".$_SESSION['id']."'";
           // $res = mysqli_query($con,$sql) or die(mysql_error());
            //$rows = mysqli_fetch_assoc($res);
           // $roomid=$rows['roomid'];
            //查詢所在的房間
            //$sql = "SELECT * FROM room WHERE host ='".$rows['roomhost']."'";
           // $res = mysqli_query($con,$sql) or die(mysql_error());
           // $rows = mysqli_fetch_assoc($res);
           // $number=$rows['number']-1;

            //是房主則關掉房間
            if($_SESSION['id']==$_SESSION['roomhost']){
               // $sql = "DELETE FROM room WHERE host='".$_SESSION['username']."'";
                //$res = mysqli_query($con,$sql) or die(mysql_error());
                $sql = "UPDATE user SET state = '0' WHERE roomhost = '".$_SESSION['id']."' ";
                $res = mysqli_query($con,$sql) or die(mysql_error());
                $sql = "UPDATE user SET roomhost = '' WHERE roomhost = '".$_SESSION['id']."' ";
                $res = mysqli_query($con,$sql) or die(mysql_error());
                $sql = "DELETE FROM mailbox WHERE sender = '".$_SESSION['username']."' ";
                mysqli_query($con,$sql) or die(mysqli_error($con));
                $sql = "DELETE FROM team WHERE host = '".$_SESSION['id']."' ";
                mysqli_query($con,$sql) or die(mysqli_error($con));
                
            }else{
                $sql = "UPDATE user SET state = '0' WHERE id = '".$_SESSION['id']."' ";
                $res = mysqli_query($con,$sql) or die(mysql_error());
                $sql = "UPDATE user SET roomhost = '' WHERE id = '".$_SESSION['id']."' ";
                $res = mysqli_query($con,$sql) or die(mysql_error());

            }
            mysqli_close($con);
             header("location:room.php");


?>
