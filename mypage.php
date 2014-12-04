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
        <script type="text/javascript" src="js/jquery-1.3.2-min.js"></script>
<script type="text/javascript" src="js/jquery.Jcrop.js"></script>
        <script language="JavaScript">
            var user_account = '<?php echo $login_flag;?>';
        </script> 
        <style type="text/css">
            .crop_preview{position:absolute; left:0px; top:0; width:220px; height:220px; overflow:hidden;}
        </style>
    </head>
    
    <body>
        <div id="main">
            <a href="http://frozen-dusk-3508.herokuapp.com/index.php"><img class="logo" src="image/logo.png"></a>
            <div id="login_pic"></div>
            <div id="login_name"> </div>
            <a href="http://frozen-dusk-3508.herokuapp.com/login.php"><img id="login" class="login" src="image/login.png"></a>
            <a href="http://frozen-dusk-3508.herokuapp.com/register.php"><img id="register" class="register" src="image/register.png"></a>
            <img class="menu" src="image/menu.png">
            <img class="choose_mypage" src="image/menu_choose.png">
            <a id="home_text" href="http://frozen-dusk-3508.herokuapp.com/index.php">首頁</a>
            <a id="match_text" href="http://frozen-dusk-3508.herokuapp.com/match.php">即時配對</a>
            <a id="mypage_text" href="http://frozen-dusk-3508.herokuapp.com/mypage.php">我的頁面</a>
            <a id="history_text" href="http://frozen-dusk-3508.herokuapp.com/history.php">我的活動</a>
            <a id="suggest_text" href="http://frozen-dusk-3508.herokuapp.com/suggest.php">推薦行程</a>
            
            <img class="mypage_selfinfo" src="image/mypage_selfinfo.png">
            <img class="mypage_friend" src="image/mypage_friend.png">
            <img class="mypage_favorate" src="image/mypage_favorate.png">
            <img class="mypage_serch" src="image/mypage_search.png">
            <img class="mypage_icon_left" src="image/mypage_icon_left.png">
            <img class="mypage_icon_right" src="image/mypage_icon_right.png">
            
           <div id="mypage_pic">
           <span id="preview_box" class="mypage_crop"></span>
           </div>
        
            <div id="mypage_left_info">
                
            </div>
            <div id="mypage_left_wmatsay"></div>

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
                             self.location = 'http://frozen-dusk-3508.herokuapp.com/index.php';
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
                             $('#login_name').text(response.login_name+'　您好');
                            
                            $('#login_pic').html('<img id="mypage_crop" src="data:image/jepg;base64,'+ response.pic + '" />');  
                            var p = 35/220;
                             $("#mypage_crop").css({
                                        width:Math.round(response.pic_w*p)+"px",	//预览图片宽度为计算比例值与原图片宽度的乘积
					height:Math.round(response.pic_h*p)+"px",	//预览图片高度为计算比例值与原图片高度的乘
					marginLeft:"-"+Math.round(response.pic_ml*p)+"px",
					marginTop:"-"+Math.round(response.pic_mt*p)+"px"
				});  
                             $('#preview_box').html('<img id="mypage_crop１" src="data:image/jepg;base64,'+ response.pic + '" />');  
                             $("#mypage_crop１").css({
                                        width:response.pic_w+"px",	//预览图片宽度为计算比例值与原图片宽度的乘积
					height:response.pic_h+"px",	//预览图片高度为计算比例值与原图片高度的乘
					marginLeft:"-"+response.pic_ml+"px",
					marginTop:"-"+response.pic_mt+"px"
				});
                                var sex;
                           if(response.user_sex==0){
                               sex = 0;
                           }else{
                               sex = 1;
                           }
                           
                            $('#mypage_left_info').append('<div>姓名：'+response.user_name+'</div>');
                            $('#mypage_left_info').append('<div>性別：'+sex+'</div>');
                            $('#mypage_left_info').append('<div>生日：'+response.user_birthday+'</div>');
                            $('#mypage_left_info').append('<div>學校：'+response.user_school+'</div>');
                            $('#mypage_left_info').append('<div>生日：'+response.user_department+'</div>');
                            }
                            }); 
                            
        }else{
            self.location = 'http://frozen-dusk-3508.herokuapp.com/login.php';
        }    
        });
        </script>
    
    
    </body>
</html>