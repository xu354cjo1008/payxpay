<?php 
    session_start(); 
    if(isset($_SESSION['user_account'])){
        $login_flag = "1";
    }else{
        $login_flag = "0";
    }
    
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/partner.css"/>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script language="JavaScript">
        var user_account = '<?php echo $login_flag;?>';
        </script> 
    </head>
    <body>
        <div id="main">
            <a href="http://payxpay.herokuapp.com/index.php"><img class="logo" src="image/logo.png"></a>
            
            <a href="http://payxpay.herokuapp.com/login.php"><img id="login" class="login" src="image/login.png"></a>
            <a href="http://payxpay.herokuapp.com/register.php"><img id="register" class="register" src="image/register.png"></a>
            
                <div id="login_pic"></div>
                <div id="login_name"> </div>
                
          
            <img class="menu" src="image/menu.png">
            <img class="choose_suggest" src="image/menu_choose.png">
            <a id="home_text" href="http://payxpay.herokuapp.com/index.php">首頁</a>
            <a id="match_text" href="http://payxpay.herokuapp.com/match.php">即時配對</a>
            <a id="mypage_text" href="http://payxpay.herokuapp.com/mypage.php">我的頁面</a>
            <a id="history_text" href="http://payxpay.herokuapp.com/history.php">我的活動</a>
            <a id="suggest_text" href="http://payxpay.herokuapp.com/suggest.php">推薦行程</a>
            
            
            
        </div>
        <script language="JavaScript">      
        $(document).ready(function(){
            if(user_account == 1){     
               document.getElementById("login").style.display='none';
               document.getElementById("register").style.display='none';      
                var img = new Image();
                img.src = "image/logout.png";
                img.id = "logout";
                img.setAttribute('class','register');    
                $("#main").append(img);
                document.getElementById('logout').style.cursor = 'pointer';         
                $('#logout').click(function(){
                    $.ajax({
                                url: 'logout.php',                  
                                dataType: 'html',
                                type:'POST',
                                error: function(xhr) {  
                                },
                                success: function(response) {
                                 self.location = 'http://payxpay.herokuapp.com/home.php';
                                }
                                });  
                });
                $.ajax({
                            url: 'mypage_showpic.php',                  
                            dataType: 'json',
                            type:'POST',
                            error: function(xhr) {  
                            },
                            success: function(response) {
                            $('#login_name').text(response.login_name+'您好');
                            
                            $('#login_pic').html('<img id="mypage_crop" src="data:image/jepg;base64,'+ response.pic + '" />');  
                            var p = 35/220;
                             $("#mypage_crop").css({
                                        width:Math.round(response.pic_w*p)+"px",	//预览图片宽度为计算比例值与原图片宽度的乘积
					height:Math.round(response.pic_h*p)+"px",	//预览图片高度为计算比例值与原图片高度的乘
					marginLeft:"-"+Math.round(response.pic_ml*p)+"px",
					marginTop:"-"+Math.round(response.pic_mt*p)+"px"
				});  
                            }
                            });  
                
                
        }else{
            self.location = 'http://payxpay.herokuapp.com/login.php';   
        }    
        });
        </script>
    </body>
</html>