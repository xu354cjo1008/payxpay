<?php
//echo $_POST['invitename'];
include_once("logdata.php");
$con = mysqli_connect($dbhost, $dbuser, $dbpass);
 mysqli_select_db($con,$dbname);
$sql = "SELECT * FROM user WHERE username ='".$_POST['invitename']."'";
$res=mysqli_query($con,$sql) or die(mysqli_error($con));
$rows = mysqli_fetch_assoc($res);
//$con = mysqli_connect($dbhost, $dbuser, $dbpass);
//mysqli_select_db($con,$dbname);
session_start();
$sql = "UPDATE user SET state = '1' WHERE id= '".$_SESSION['id']."'";
mysqli_query($con,$sql) or die(mysqli_error($con));
$sql = "UPDATE user SET roomhost = '".$rows['id']."' WHERE id= '".$_SESSION['id']."'";
mysqli_query($con,$sql) or die(mysqli_error($con));
$sql = "DELETE FROM mailbox WHERE fid = '".$_SESSION['id']."' ";
mysqli_query($con,$sql) or die(mysqli_error($con));
mysqli_close($con);
header("location:room.php"); 

?>
