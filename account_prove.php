<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body> 
<?php
            include 'MYSQL_info.php';
$PNcode = $_GET['PNcode'];
$user_account = $_GET['user_account'];

            
            $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
            if($conn){
                mysql_query("SET NAMES 'utf8'");
                mysql_select_db($dbname);

                $sql = "SELECT * FROM `user_info` WHERE user_account='$user_account'";

                $result = mysql_query($sql) or die('MySQL query error');
	
                while($row = mysql_fetch_array($result)){
                    if($row["PNcode"]==$PNcode){
                        //good                    
                        $sql="UPDATE user_info SET PNcode='1' WHERE user_account='$user_account'";
                        mysql_query($sql);    
                        mysql_close($conn);
                        
                        header("Location: http://frozen-dusk-3508.herokuapp.com/home.php");
                        
                    }else if($row["PNcode"]=="1"){
                        echo "已認證完成";
                    }else{
                        GG;
                    }
                }
            }else{
             echo "damn";
            }
            

            
?>
    </body>
</html>