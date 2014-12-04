<?php
include_once("logdata.php");
$con = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_select_db($con,$dbname);
session_start();
$sql = "SELECT * FROM user WHERE roomhost ='".$_SESSION['roomhost']."'";
$res = mysqli_query($con,$sql) or die(mysqli_error($con));
$number=0;
while($record = mysqli_fetch_array($res)){
   $arr[]=$record['username'];
}
mysqli_close($con);

echo json_encode($arr);
?>
