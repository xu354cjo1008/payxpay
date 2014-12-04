<?php
session_start();
 if($_SESSION['state']=='0'){

//寫入room table
           include_once("logdata.php");
            $con = mysqli_connect($dbhost, $dbuser, $dbpass);
            mysqli_query($con,"SET NAMES 'utf8'");
            mysqli_select_db($con,$dbname);
        //    $name=$_SESSION['username'];
//            $sql = "INSERT INTO room (number,host) VALUES ('1','".$_SESSION['id']."')";
//            echo $_SESSION['username'];
//            if (!mysqli_query($con,$sql))
//              {
//                  die('Error: ' . mysqli_error($con));
//              }
//              echo "1 record added";
              //更新session和user table
              // $sql = "SELECT * FROM room WHERE host ='".$_SESSION['username']."'";
            //   $res = mysql_query($sql) or die(mysql_error());
            //   $rows = mysql_fetch_assoc($res);
            //   $roomid=$rows['roomid'];
             //  $username=$_SESSION['username'];
               $sql = "UPDATE user SET roomhost = '".$_SESSION['id']."' WHERE id = '".$_SESSION['id']."' ";
               $res = mysqli_query($con,$sql) or die(mysql_error());
               $sql = "UPDATE user SET state = '1' WHERE id = '".$_SESSION['id']."'";
               $res = mysqli_query($con,$sql) or die(mysql_error());
               //$_SESSION['roomhost'] = $_SESSION['id'];
               //$_SESSION['state']='1';
               mysqli_close($con);
                header("location:room.php");  
 }
?>
