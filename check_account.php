<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body> 
<?php
            include 'MYSQL_info.php';
            $ee = "OK";
            $user_account = $_POST['user_account'];

            $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
            if($conn){
                mysql_query("SET NAMES 'utf8'");
                mysql_select_db($dbname);

                $sql = "SELECT * FROM `user_info` WHERE user_account='$user_account'";

                $result = mysql_query($sql) or die('MySQL query error');
        
               while($row = mysql_fetch_array($result)){
                    $ee = "有人用過摟!";
                } 
                echo $ee;
                mysql_close($conn);
                //header("Location: http://localhost/V1/register2.php?user_account=".$_GET["user_account"]);
                exit;
            }else{
             echo "damn";
            }
            
?>
    </body>
</html>