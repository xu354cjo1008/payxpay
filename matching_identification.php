<?php
     session_start();
     if(isset($_SESSION['user_account'])) {
            $dbhost = '127.0.0.1';
            $dbuser = 'root';
            $dbpass = '';
            $dbname = 'partnera';
            $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');            
            if($conn){
                mysql_query("SET NAMES 'utf8'");
                mysql_select_db($dbname);
                $query = "SELECT * FROM user_info WHERE id ='".$_SESSION['id']."'";
                $res=mysql_query($query,$conn) or die(mysql_error());
                $rows = mysql_fetch_assoc($res);
                $_SESSION['user_state'] = $rows['user_state'];
                $_SESSION['user_host'] = $rows['user_host'];
                $_SESSION['match_id'] = $rows['match_id'];
                mysql_close($conn);    
                if($_SESSION['user_state']=='0')
                     header("location: http://localhost/V1/match_start.php");
                else if($_SESSION['user_state']=='1' || $_SESSION['user_state']=='2')
                    header("location: http://localhost/V1/match.php");
                else if($_SESSION['user_state']=='3')
                    ;
                        
            }else{
             echo "damn";
            }session_write_close();
     }else{
         session_write_close();
         header("location: http://localhost/V1/PhpProject8/index.php");
     }
?>
