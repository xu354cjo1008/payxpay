<!DOCTYPE html>
<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!--      <link href="jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
      <script src="jquery.mCustomScrollbar.concat.min.js"></script>-->
    <title></title>
  </head>
  <body>
      <script>
//    (function($){
//        $(window).load(function(){
//            $(".content").mCustomScrollbar();
//            set_width:20;set_height:20;
//        });
//    })(jQuery);
</script>
<!--<div class="content">aaaaaaaaa</div>-->
  <?php
  session_start();
  if(isset($_SESSION['username'])) {
  echo "You're logged as: " . $_SESSION['username'];
  echo "</br/>" . '<form action = "logout.php" method = "get">
  <input type = "submit" name = "logout" value = "Logout"></form>';
  echo "</br/>" . '<form action = "room.php" method = "get">
      <input type = "submit" name = "room" value = "到房間頁面"></form>';
//  if($_SESSION['state']=='0')
//  {
//      echo "</br/>" . '<form action = "room.php" method = "get">
//      <input type = "submit" name = "room" value = "開房間"></form>';
//  }else if($_SESSION['state']=='1'){
//      echo "</br/>" . '<form action = "room.php" method = "get">
//      <input type = "submit" name = "room" value = "去房間"></form>';
//  }else if($_SESSION['state']=='2'){
//      echo "</br/>" . '<form action = "match.php" method = "get">
//      <input type = "submit" name = "match" value = "去配對"></form>';
//  }else if($_SESSION['state']=='3'){
//      echo "</br/>" . '<form action = "friendship.php" method = "get">
//      <input type = "submit" name = "friendship" value = "去聯誼"></form>';
//  }
  } else {
  echo'
  <form action = "login_validate.php" method = "POST">
  <h2>Login System with MySQL</h2>
  Username: 
  <input type = "text" name = "username">
  <br />
  Password: 
  <input type = "password" name = "password">
  <br />
  <input type = "submit" value = "Login">
  <input type = "reset" value = "Reset">
  </form>
  ';
  } 
  ?>
  </body>
</html>