<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title></title>
</head>
<body>
<?php
            include 'MYSQL_info.php';
            $user_account = $_POST["user_account"];
            $user_password = $_POST["user_password"];
            $user_name = $_POST["user_name"];
            $user_birthday = $_POST["user_birthday"];
            $user_schoolemail = $_POST["user_schoolemail"];
            $user_sex = $_POST["user_sex"];
            $user_school = $_POST["user_school"];
            $user_department = $_POST["user_department"];
            if($user_account!=NULL && $user_password!=NULL && $user_name!=NULL){

            $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
            if($conn){
                mysql_query("SET NAMES 'utf8'");
                mysql_select_db($dbname);

                $query ="INSERT INTO user_info (user_account,user_password,user_name,user_sex,user_birthday,user_school,user_department,user_schoolemail)
                    VALUES ('$user_account','$user_password','$user_name','$user_sex','$user_birthday','$user_school','$user_department','$user_schoolemail')";

                mysql_query($query , $conn) or die('Insert data fail');
                mysql_close($conn);
                header("Location: http://localhost/V1/register2.php?user_account=".$_POST["user_account"]);
                exit;
            }else{
             echo "damn";
            }
            }
       
       
        ?>
</body>


</html>