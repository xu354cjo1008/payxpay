<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <title></title>
    </head>
    <body> 
<?php
    include 'MYSQL_info.php';
    $pic_w=$_POST['pic_w'];
    $pic_h=$_POST['pic_h'];
    $pic_ml=$_POST['pic_ml'];
    $pic_mt=$_POST['pic_mt'];
    $user_account=$_GET['user_account'];

    
    
    //取得上傳檔案資訊
    $filename=$_FILES['image']['name'];
    $tmpname=$_FILES['image']['tmp_name'];
    $filetype=$_FILES['image']['type'];
    $filesize=$_FILES['image']['size'];    
    $file=NULL;
    
    if(isset($_FILES['image']['error'])){    
        if($_FILES['image']['error'] === 0){                                    
            $instr = fopen($tmpname,"rb" );
            $file = addslashes(fread($instr,filesize($tmpname)));        
        }
    }
    
    
    
        //認證碼產生
        function randomkeys($length){
        $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
        for($i=0;$i<$length;$i++){
        $key .= $pattern{rand(0,35)};
        }
        return $key;
        }      

        
        $PNcode = randomkeys(20);
    
    
    
    //新增圖片到資料庫
    
        $conn=mysql_connect($dbhost, $dbuser, $dbpass);        
        mysql_select_db("partnera");
        mysql_query("SET NAMES'utf8'");
        
        
 
        $sql = "SELECT * FROM `user_info` WHERE user_account='$user_account'";

                $result = mysql_query($sql) or die('MySQL query error');
        
                
                while($row = mysql_fetch_array($result)){
                    $schoolemail = $row["user_schoolemail"];
                }            

        $sql="UPDATE user_info SET user_pic='$file' , pic_w='$pic_w' , pic_h='$pic_h' , pic_ml='$pic_ml' , pic_mt='$pic_mt' , PNcode='$PNcode' WHERE user_account = '$user_account'";
        mysql_query($sql);    
        mysql_close($conn);
        
        
        
        //-----------寄認證信-----------------
        require("mail/_acp-ml/modules/phpmailer/class.phpmailer.php");
        mb_internal_encoding('UTF-8');   
        $mail->CharSet = "UTF-8";


        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true; // turn on SMTP authentication
        //這幾行是必須的
        $mail->Username = "conan6931@gmail.com";
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
        $xx = "http://payxpay.herokuapp.com/account_prove.php?user_account=".$user_account."&PNcode=".$PNcode;
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
        header("Location: http://payxpay.herokuapp.com/register3.php");

?>
    </body>
</html>