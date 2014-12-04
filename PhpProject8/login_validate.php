<?php
session_start(); 
?>

<?php
             $dbhost = '127.0.0.1';
              $dbuser = 'root';
              $dbpass = '';
              $dbname = 'partnera';
mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname) or die(mysql_error());
if (!empty($_POST['username']) or !empty($_POST['password'])) {

    $user = trim($_POST['username']);

    $pass = trim($_POST['password']);

 @$sql = "SELECT * FROM user_info WHERE user_account ='".$user."' AND user_password = '".$pass."' LIMIT 1";

 $res = mysql_query($sql) or die(mysql_error());

 if (mysql_num_rows($res) == 1) {

  $rows = mysql_fetch_assoc($res);
  
  $_SESSION['id'] = $rows['id'];
  $_SESSION['user_account'] = $rows['user_account'];
  $_SESSION['user_name'] = $rows['user_name'];
  $_SESSION['user_sex'] = $rows['user_sex'];
  $_SESSION['user_state'] = $rows['user_state'];
  $_SESSION['user_host'] = $rows['user_host'];
  //$_SESSION['matchid'] = $rows['matchid'];
  //$_SESSION['friendshipid'] = $rows['friendshipid'];

  header("location: http://localhost/V1/home.php");

 } else {

  echo "Invalid login information.";
  //$aqq=md5($pass);
  exit();

 }

    } else {

      echo "Please input username and password!";

    }





?>
