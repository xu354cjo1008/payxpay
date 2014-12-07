<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/partner.css"/>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    </head>
    <body>
        <div id="main">
            <a href="http://payxpay.herokuapp.com/index.php"><img class="logo" src="image/logo.png"></a>
<!--            <img class="login" src="image/login.png">
            <a href="http://localhost/V1/register.php"><img class="register" src="image/register.png"></a>-->
            <img class="login_bg" src="image/login_bg.png">
            
            <form id="myfrom" name="myform" action="login_check.php" method="post" accept-charset="utf-8" onsubmit="return Q();">
                <input type="text" id="user_account" name="user_account" class="login_account" onBlur="check_account()"/>
                <input type="password" id="user_password" name="user_password" class="login_password" onBlur="check_password()"/>
                <div id="login_button">
                    <input id="submit" type="image"img src="image/login_button.png" >
                    </div>
            </form>
           
            <div id="login_text_account">使用者帳號</div>
            <div id="login_text_password">使用者密碼</div>
            
            <a id="login_forget" href="#">忘記密碼?</a>
            <a id="login_register" href="http://payxpay.herokuapp.com/register.php">註冊新帳號</a>
            
        </div>
        <script language="JavaScript">
            var alert_text = <?php echo $_GET['prove']?>;
            var id = <?php echo $_GET['id']?>;
            if(alert_text==0){
                myalert();
            }
            
            
            function myalert()
            {
            var x;
            var r=confirm("此帳號還沒通過認證，是否需要認證信重寄?");
            if (r==true)
              {
                  $.ajax({
                            url: 'resend_provemail.php',
                            data: {id: id},
                            dataType: 'html',
                            type:'POST',
                            error: function(xhr) {
                                
                            },
                            success: function(response) {
                                $('#login_text_password').html(response);
                                 window.alert('認證信已寄到註冊的學生信箱!');
                            }
                            });
              }
            else
              {
//              x="You pressed Cancel!";
              }

            }
            
            
        </script> 
    </body>
</html>