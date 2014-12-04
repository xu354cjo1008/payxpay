<?php
include_once("logdata.php");
$con = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_select_db($con,$dbname);
session_start();
$sql = "SELECT * FROM mailbox WHERE fid ='".$_SESSION['id']."' AND flag='0'";
$res = mysqli_query($con,$sql) or die(mysqli_error($con));
while($record = mysqli_fetch_array($res)){
      $arr[]=$record['sender'];
      $arr[]=$record['content'];
}
$sql = "UPDATE mailbox SET flag = '1' WHERE fid= '".$_SESSION['id']."' AND flag='0'";
mysqli_query($con,$sql) or die(mysqli_error($con));
mysqli_close($con);

echo json_encode($arr);

?>
