<?php
            include 'MYSQL_info.php';
            
            session_start();
            $user_account = $_POST["user_account"];
            $user_password = $_POST["user_password"];
            
            
            $conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
            if($conn){
                mysqli_query("SET NAMES 'utf8'");
                mysqli_select_db($dbname);
                
                $sql = "SELECT * FROM `user_info` WHERE `user_account`='".$user_account."'";

                $result = mysqli_query($sql) or die('MySQL query error');
        
                
                while($row = mysqli_fetch_array($result)){
                    $password = $row['user_password'];
                    if($user_password===$password){
                        if($row['PNcode'] == "1"){
                            $_SESSION['id'] = $row['id'];
                            $_SESSION['user_account'] = $row['user_account'];
                            $_SESSION['user_password'] = $row['user_password'];
                            $_SESSION['user_name'] = $row['user_name'];
                            $_SESSION['user_sex'] = $row['user_sex'];
                            $_SESSION['user_birthday'] = $row['user_birthday'];
                            $_SESSION['user_school'] = $row['user_school'];
                            $_SESSION['user_department'] = $row['user_department'];
                            $_SESSION['user_schoolemail'] = $row['user_schoolemail'];
                            $_SESSION['user_pic'] = $row['user_pic'];
                            $_SESSION['pic_w'] = $row['pic_w'];
                            $_SESSION['pic_h'] = $row['pic_h'];
                            $_SESSION['pic_ml'] = $row['pic_ml'];
                            $_SESSION['pic_mt'] = $row['pic_mt'];
                            $_SESSION['PNcode'] = $row['PNcode'];
                            $_SESSION['user_state'] = $row['user_state'];
                            $_SESSION['user_host'] = $row['user_host'];
                            $_SESSION['match_id'] = $row['match_id'];
                            
                            header("Location: http://frozen-dusk-3508.herokuapp.com/index.php");
                        }else{
                            header("Location: http://frozen-dusk-3508.herokuapp.com/login.php?prove=0&id=".$row['id']);
                        }
                    }else{
                        header("Location: http://frozen-dusk-3508.herokuapp.com/login.php");
                    }   
                }            
               
                  
            }else{
             echo "damn";
            }
            
?>
