<?php
session_start();
if(isset($_SESSION['username'])) {
unset($_SESSION['username']); //清除單一項目
session_destroy(); //全部清除
}
header("location:index.php");
?>
