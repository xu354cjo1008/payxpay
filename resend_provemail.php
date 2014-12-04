<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <title></title>
    </head>
    <body> 
<?php

$id = $_POST['id'];

include 'MYSQL_info.php';
 $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
            if($conn){
                    
                     
                mysql_select_db("partnera");
                mysql_query("SET NAMES'utf8'");
                $sql = "SELECT * FROM `user_info` WHERE id='$id'";
                $result = mysql_query($sql) or die('MySQL query error');
        
                while($row = mysql_fetch_array($result)){
                    $schoolemail = $row["user_schoolemail"];
                    $user_account = $row["user_account"];
                    $PNcode = $row["PNcode"];
                }   
                
                    
                
                
                //-----------寄認證信-----------------
                    require("mail/_acp-ml/modules/phpmailer/class.phpmailer.php");
                    mb_internal_encoding('UTF-8');   
                    $mail->CharSet = "UTF-8";


                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->SMTPAuth = true; // turn on SMTP authentication
                    //這幾行是必須的
                    $mail->Username = "steve@yic.mygbiz.com";
                    $mail->Password = "98123060";
                    //這邊是你的gmail帳號和密碼
                    $mail->FromName = mb_encode_mimeheader("男女配不配", "UTF-8");
                    // 寄件者名稱(你自己要顯示的名稱)
                    $webmaster_email = "steve@yic.mygbiz.com"; 
                    //回覆信件至此信箱
                    //$email="xu354cjo1008@gmail.com";
                    $email=$schoolemail;
                    // 收件者信箱
                    $name="親愛的用戶";
                    // 收件者的名稱or暱稱
                    $mail->From = $webmaster_email;
                    $mail->AddAddress($email,$name);
                    $mail->AddReplyTo($webmaster_email,"Squall.f");
                    //這不用改
                    $mail->WordWrap = 50;
                    //每50行斷一次行
                    //$mail->AddAttachment("/XXX.rar");
                    // 附加檔案可以用這種語法(記得把上一行的//去掉)
                    $mail->IsHTML(true); // send as HTML
                    $mail->Subject = mb_encode_mimeheader("男女配不pay註冊帳號認證信", "UTF-8"); 
                    // 信件標題
                    $xx = "http://localhost/V1/account_prove.php?user_account=".$user_account."&PNcode=".$PNcode;
                    $string = mb_encode_mimeheader("點點我", "UTF-8");
                    $mail->Body = '<a href='.$xx.'>點點我</a>';
                    //信件內容(html版，就是可以有html標籤的如粗體、斜體之類)
                    //$mail->AltBody = "信件內容"; 
                    //信件內容(純文字版)
                    if(!$mail->Send()){
                    echo "寄信發生錯誤：" . $mail->ErrorInfo;
                    //如果有錯誤會印出原因
                    }
                    else{ 
                    echo "寄信成功";
                    }
                    //-----------     
                
            }else{
             echo "damn";
            }
            
            
            
?>
    </body>
</html>