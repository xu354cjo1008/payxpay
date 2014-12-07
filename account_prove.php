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

            
            $conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
            if($conn){
                mysqli_query("SET NAMES 'utf8'");
                mysqli_select_db($dbname);

                $sql = "SELECT * FROM `user_info` WHERE `user_account`='$user_account'";

                $result = mysqli_query($sql) or die('MySQL query error');
	
                while($row = mysqli_fetch_array($result)){
                    if($row["PNcode"]==$PNcode){
                        //good                    
                        $sql="UPDATE user_info SET PNcode='1' WHERE user_account='$user_account'";
                        mysqli_query($sql);    
                        mysqli_close($conn);
                        
                        header("Location: http://payxpay.herokuapp.com/index.php");
                        
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