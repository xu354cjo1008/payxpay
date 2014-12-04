<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/partner.css"/>
        <link rel="stylesheet" type="text/css" href="css/selectik.css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="js/jquery.selectik.js"></script>
    </head>
    <body>
        
        
        <div id="main">
            <a href="http://localhost/V1/home.php"><img class="logo" src="image/logo.png"></a>
            <img class="register_bg" src="image/register_bg.png">
            <img class="register_content" src="image/register_content.png">
            <img class="register_icon1" src="image/register_icon_normal.png">
            <img class="register_icon2" src="image/register_icon_gray.png">
            <img class="register_icon3" src="image/register_icon_gray.png">
            <div id="register_step1" style="color: #000000;">填寫基本資料</div>
            <div id="register_step2" style="color: #dcdcdc;">上傳照片</div>
            <div id="register_step3" style="color: #dcdcdc;">完成認證</div>
            <div id="register_no1">1</div>
            <div id="register_no2">2</div>
            <div id="register_no3">3</div>
            
            <div id="register_text1">建立您的男女配不PAY帳號，請依照以下1.2.3.步驟完成。</div>
            <div id="register_text2">學校認證信箱主要目的為確認學生身分，往後配對通知均以帳號信箱為主發送通知。</div>
            
            
            
             <div>
                <form id="myfrom" name="myform" action="register_sql.php" method="post" accept-charset="utf-8" onsubmit="return Q();">
                    
                    <input type="text" id="user_account" name="user_account" class="register_account" onBlur="check_account()"/>
                    <input type="password" id="user_password" name="user_password" class="register_password" onBlur="check_password()"/>
                    <input type="password" id="user_password_re" name="user_password_re" class="register_password_re" onBlur="check_password()"/>
                    <input type="text" id="user_name" name="user_name" class="register_name" />
                    <input type="text" id="user_birthday" name="user_birthday" class="register_birthday" onBlur="check_birthday()"/>
                    <input type="text" id="user_schoolemail" name="user_schoolemail" class="register_schoolemail" onBlur="check_schoolemail()"/>
                    <div class="sex" id="register_sex">
                    <select name="user_sex">
                        <option value="0">女</option>
                        <option value="1">男</option>
                        
                    </select>
                    </div>
                    <div class="school" id="register_school">
                    <select name="user_school">
                        <option value="基隆市" disabled="disabled">基隆市</option>
                        <option value="國立臺灣海洋大學">國立臺灣海洋大學</option>
                        <option value="經國管理暨健康學院">經國管理暨健康學院</option>
                        <option value="崇右技術學院">崇右技術學院</option>
                        
                        <option value="台北市" disabled="disabled">台北市</option>
                        <option value="國立政治大學">國立政治大學</option>
                        <option value="國立臺灣大學">國立臺灣大學</option>
                        <option value="國立臺灣師範大學">國立臺灣師範大學</option>
                        <option value="國立陽明大學">國立陽明大學</option>
                        <option value="國立臺北藝術大學">國立臺北藝術大學</option>
                        <option value="國立臺北教育大學">國立臺北教育大學</option>
                        <option value="臺北市立教育大學">臺北市立教育大學</option>
                        <option value="臺北市立體育學院">臺北市立體育學院</option>
                        <option value="東吳大學">東吳大學</option>
                        <option value="中國文化大學">中國文化大學</option>
                        <option value="世新大學">世新大學</option>
                        <option value="銘傳大學">銘傳大學</option>
                        <option value="實踐大學">實踐大學</option>
                        <option value="大同大學">大同大學</option>
                        <option value="臺北醫學大學">臺北醫學大學</option>
                        <option value="國立臺灣科技大學">國立臺灣科技大學</option>
                        <option value="國立臺北科技大學">國立臺北科技大學</option>
                        <option value="國立臺北護理健康大學">國立臺北護理健康大學</option>
                        <option value="國立臺北商業技術學院">國立臺北商業技術學院</option>
                        <option value="國立臺灣戲曲學院">國立臺灣戲曲學院</option>
                        <option value="中國科技大學">中國科技大學</option>
                        <option value="德明財經科技大學">德明財經科技大學</option>
                        <option value="中華學校財團法人中華科技大學">中華學校財團法人中華科技大學</option>
                        <option value="城市學校財團法人台北城市科技大學">城市學校財團法人台北城市科技大學</option>
                        <option value="台北海洋技術學院">台北海洋技術學院</option>
                        <option value="國防醫學院">國防醫學院</option>
                        
                        <option value="新北市" disabled="disabled">新北市</option>
                        <option value="國立臺北大學">國立臺北大學</option>
                        <option value="國立臺灣藝術大學">國立臺灣藝術大學</option>
                        <option value="輔仁大學">輔仁大學</option>
                        <option value="淡江大學">淡江大學</option>
                        <option value="華梵大學">華梵大學</option>
                        <option value="真理大學">真理大學</option>
                        <option value="馬偕醫學院">馬偕醫學院</option>
                        <option value="法鼓佛教學院">法鼓佛教學院</option>
                        <option value="臺北基督學院">臺北基督學院</option>
                        <option value="明志科技大學">明志科技大學</option>
                        <option value="聖約翰科技大學">聖約翰科技大學</option>
                        <option value="景文科技大學">景文科技大學</option>
                        <option value="東南科技大學">東南科技大學</option>
                        <option value="致理技術學院">致理技術學院</option>
                        <option value="醒吾科技大學">醒吾科技大學</option>
                        <option value="亞東技術學院">亞東技術學院</option>
                        <option value="德霖技術學院">德霖技術學院</option>
                        <option value="黎明技術學院">黎明技術學院</option>
                        <option value="華夏技術學院">華夏技術學院</option>
                        <option value="國立空中大學">國立空中大學</option>
                        
                        
                        <option value="桃園縣" disabled="disabled">桃園縣</option>
                        <option value="國立中央大學">國立中央大學</option>
                        <option value="國立體育大學">國立體育大學</option>
                        <option value="中原大學">中原大學</option>
                        <option value="長庚大學">長庚大學</option>
                        <option value="元智大學">元智大學</option>
                        <option value="開南大學">開南大學</option>
                        <option value="龍華科技大學">龍華科技大學</option>
                        <option value="健行科技大學">健行科技大學</option>
                        <option value="萬能科技大學">萬能科技大學</option>
                        <option value="長庚科技大學">長庚科技大學</option>
                        <option value="桃園創新技術學院">桃園創新技術學院</option>
                        <option value="國防大學">國防大學</option>
                        <option value="中央警察大學">中央警察大學</option>
                        
                        <option value="新竹市" disabled="disabled">新竹市</option>
                        <option value="國立清華大學">國立清華大學</option>
                        <option value="國立新竹教育大學">國立新竹教育大學</option>
                        <option value="中華大學">中華大學</option>
                        <option value="玄奘大學">玄奘大學</option>
                        <option value="元培科技大學">元培科技大學</option>
                        <option value="國立交通大學">國立交通大學</option>
                        <option value="明新科技大學">明新科技大學</option>
                        <option value="大華科技大學">大華科技大學</option>
                        
                        <option value="苗栗市" disabled="disabled">苗栗市</option>
                        <option value="國立聯合大學">國立聯合大學</option>
                        <option value="育達商業科技大學">育達商業科技大學</option>
                        <option value="亞太創意技術學院">亞太創意技術學院</option>
                        
                        <option value="台中市" disabled="disabled">台中市</option>
                        <option value="國立中興大學">國立中興大學</option>
                        <option value="國立臺中教育大學">國立臺中教育大學</option>
                        <option value="國立臺灣體育運動大學">國立臺灣體育運動大學</option>
                        <option value="東海大學">東海大學</option>
                        <option value="逢甲大學">逢甲大學</option>
                        <option value="靜宜大學">靜宜大學</option>
                        <option value="中山醫學大學">中山醫學大學</option>
                        <option value="中國醫藥大學">中國醫藥大學</option>
                        <option value="亞洲大學">亞洲大學</option>
                        <option value="國立勤益科技大學">國立勤益科技大學</option>
                        <option value="國立臺中科技大學">國立臺中科技大學</option>
                        <option value="朝陽科技大學">朝陽科技大學</option>
                        <option value="弘光科技大學">弘光科技大學</option>
                        <option value="嶺東科技大學">嶺東科技大學</option>
                        <option value="中臺科技大學">中臺科技大學</option>
                        <option value="僑光科技大學">僑光科技大學</option>
                        <option value="修平科技大學">修平科技大學</option>
                        <option value="朝陽科技大學">朝陽科技大學</option>
                        
                        <option value="南投縣" disabled="disabled">南投縣</option>
                        <option value="國立暨南國際大學">國立暨南國際大學</option>
                        <option value="南開科技大學">南開科技大學</option>
                        
                        <option value="彰化縣" disabled="disabled">彰化縣</option>
                        <option value="國立彰化師範大學">國立彰化師範大學</option>
                        <option value="大葉大學">大葉大學</option>
                        <option value="明道大學">明道大學</option>
                        <option value="建國科技大學">建國科技大學</option>
                        <option value="中州科技大學">中州科技大學</option>
                        
                        <option value="雲林縣" disabled="disabled">雲林縣</option>
                        <option value="國立雲林科技大學">國立雲林科技大學</option>
                        <option value="國立虎尾科技大學">國立虎尾科技大學</option>
                        <option value="環球科技大學">環球科技大學</option>
                        
                        <option value="嘉義市" disabled="disabled">嘉義市</option>
                        <option value="國立嘉義大學">國立嘉義大學</option>
                        <option value="大同技術學院">大同技術學院</option>
                        
                        <option value="嘉義縣" disabled="disabled">嘉義縣</option>
                        <option value="國立中正大學">國立中正大學</option>
                        <option value="南華大學">南華大學</option>
                        <option value="稻江科技暨管理學院">稻江科技暨管理學院</option>
                        <option value="吳鳳科技大學">吳鳳科技大學</option>
                       
                        <option value="臺南市" disabled="disabled">臺南市</option>
                        <option value="國立成功大學">國立成功大學</option>
                        <option value="國立臺南藝術大學">國立臺南藝術大學</option>
                        <option value="國立臺南大學">國立臺南大學</option>
                        <option value="長榮大學">長榮大學</option>
                        <option value="康寧大學">康寧大學</option>
                        <option value="台灣首府大學">台灣首府大學</option>
                        <option value="興國管理學院">興國管理學院</option>
                        <option value="南台科技大學">南台科技大學</option>
                        <option value="崑山科技大學">崑山科技大學</option>
                        <option value="嘉南藥理科技大學">嘉南藥理科技大學</option>
                        <option value="台南應用科技大學">台南應用科技大學</option>
                        <option value="遠東科技大學">遠東科技大學</option>
                        <option value="中華醫事科技大學">中華醫事科技大學</option>
                        <option value="南榮技術學院">南榮技術學院</option>
                       
                        
                        <option value="高雄市" disabled="disabled">高雄市</option>
                        <option value="國立中山大學">國立中山大學</option>
                        <option value="國立高雄師範大學">國立高雄師範大學</option>
                        <option value="國立高雄大學">國立高雄大學</option>
                        <option value="義守大學">義守大學</option>
                        <option value="高雄醫學大學">高雄醫學大學</option>
                        <option value="國立高雄第一科技大學">國立高雄第一科技大學</option>
                        <option value="國立高雄應用科技大學">國立高雄應用科技大學</option>
                        <option value="國立高雄海洋科技大學">國立高雄海洋科技大學</option>
                        <option value="國立高雄餐旅大學">國立高雄餐旅大學</option>
                        <option value="樹德科技大學">樹德科技大學</option>
                        <option value="輔英科技大學">輔英科技大學</option>
                        <option value="正修科技大學">正修科技大學</option>
                        <option value="高苑科技大學">高苑科技大學</option>
                        <option value="文藻外語學院">文藻外語學院</option>
                        <option value="和春技術學院">和春技術學院</option>
                        <option value="東方設計學院">東方設計學院</option>
                        <option value="高雄市立空中大學">高雄市立空中大學</option>
                        <option value="中華民國陸軍軍官學校">中華民國陸軍軍官學校</option>
                        <option value="海軍軍官學校">海軍軍官學校</option>
                        <option value="中華民國空軍官校">中華民國空軍官校</option>
                        <option value="國立空軍航空技術學院">國立空軍航空技術學院</option>
                        
                        <option value="屏東市" disabled="disabled">屏東市</option>
                        <option value="國立屏東商業技術學院">國立屏東商業技術學院</option>
                        
                        <option value="屏東縣" disabled="disabled">屏東縣</option>
                        <option value="國立屏東教育大學">國立屏東教育大學</option>
                        <option value="國立屏東科技大學">國立屏東科技大學</option>
                        <option value="大仁科技大學">大仁科技大學</option>
                        <option value="美和科技大學">美和科技大學</option>
                        <option value="永達技術學院">永達技術學院</option>
                        <option value="高鳳數位內容學院">高鳳數位內容學院</option>
                        
                        
                        <option value="宜蘭縣" disabled="disabled">宜蘭縣</option>
                        <option value="國立宜蘭大學">國立宜蘭大學</option>
                        <option value="佛光大學">佛光大學</option>
                        <option value="蘭陽技術學院">蘭陽技術學院</option>
                        
                        <option value="花蓮縣" disabled="disabled">花蓮縣</option>
                        <option value="國立東華大學">國立東華大學</option>
                        <option value="大漢技術學院">大漢技術學院</option>
                        <option value="慈濟技術學院">慈濟技術學院</option>
                        <option value="臺灣觀光學院">臺灣觀光學院</option>
                        
                        <option value="台東縣" disabled="disabled">台東縣"</option>
                        <option value="國立臺東大學">國立臺東大學</option>
                        
                        
                    </select>
                    </div>
                    <div class="department" id="register_department">
                    <select name="user_department">
                        <option value="電資學院">文學院</option>
                        <option value="電資學院">理學院</option>
                        <option value="電資學院">社會科學院</option>
                        <option value="電資學院">管理學院</option>
                        <option value="電資學院">法律學院</option>
                        <option value="電資學院" >工學院</option>
                        <option value="電資學院">電資學院</option>
                        <option value="電資學院">公衛學院</option>
                        <option value="電資學院">生命科學院</option>
                        <option value="電資學院">社會科學院</option>
                        <option value="電資學院">醫學院</option>
                        <option value="電資學院">農學院</option>
                        <option value="電資學院">新聞傳播學院</option>
                        <option value="電資學院">藝術學院</option>
                        <option value="電資學院">設計學院</option>
                       
                    </select>
                    </div>
                    
                    <div id="register_finish">
                    <input id="submit" type="image"img src="image/register_finish.png" >
                    </div>
                </form>  
            </div>
            
            

            <div id="check_account_result"></div>
            <div id="check_password"></div>
            <div id="check_birthday">(19XX/XX/XX)</div>
            <div id="check_schoolemail"></div>
        </div>
        
         <script type="text/javascript">
             
             var x = 0;
             var x1 = 0;
             var x2 = 0;
             var x3 = 0;
//             $(document).ready(function(){
//                $("#check_account").click(function(){
//                $.ajax({
//                            url: 'check_account.php',
//                            data: {user_account: $('#user_account').val()},
//                            dataType: 'html',
//                            type:'POST',
//                            error: function(xhr) {
//                                $('#check_account_result').text("xxx");
//                            },
//                            success: function(response) {
//                                   $('#check_account_result').html(response);
//                            }
//                            });
//                });
//                });
                
                function check_password()
                {
                    if($('#user_password').val().length!==0 && $('#user_password_re').val().length!==0){
                       if($('#user_password').val()===$('#user_password_re').val()){
                           $('#check_password').text("OK");
                           document.getElementById('check_password').style.color = '#19983a';
                           x1 = 1; 
                       }else{
                           $('#check_password').text("密碼不符");
                           document.getElementById('check_password').style.color = '#e60012';
                           x1 = 0;
                       }
                    }
                }
                
                function check_account(){
                    if($('#user_account').val().length!==0){
                   $.ajax({
                            url: 'check_account.php',
                            data: {user_account: $('#user_account').val()},
                            dataType: 'html',
                            type:'POST',
                            error: function(xhr) {
                                $('#check_account_result').text("xxx");
                            },
                            success: function(response) {
                                   $('#check_account_result').html(response); 
                                   var node = document.getElementById('check_account_result'),

                                    htmlContent = node.innerHTML,
                                    textContent = node.textContent;
                                   if(textContent.match("OK")!==null){
                                       document.getElementById('check_account_result').style.color = '#19983a';
                                       x=1;
                                   }else{
                                       document.getElementById('check_account_result').style.color = '#e60012';
                                       x=0;
                                       
                                   }
                            }
                            });
                    }
                    
                }
                function check_birthday(){
                    var str = $('#user_birthday').val();
                    if(str.charAt(4)==="/" && str.charAt(7)==="/" &&  parseInt(str.substr(0,4))<2013){
                        x2=1;
                        $('#check_birthday').text("OK");
                        document.getElementById('check_birthday').style.color = '#19983a';
                    }else{
                        $('#check_birthday').text("格式(19XX/XX/XX)");
                        document.getElementById('check_birthday').style.color = '#e60012';
                        x2=0;
                    }
                }
                
                function check_schoolemail(){
                    var str = $('#user_schoolemail').val();
                    if(str.match("@")!==null){
                        document.getElementById('check_schoolemail').style.color = '#19983a';
                        $('#check_schoolemail').text("OK");
                        x3=1;
                    }else{
                        document.getElementById('check_schoolemail').style.color = '#e60012';
                        $('#check_schoolemail').text("這不是學校信箱哦!");
                        x3=0;
                    }
            
                }
                function Q(){
                    if(x==1 && x1==1 && $('#user_name').val().length!==0 && x2==1 && x3==1){
                        document.this.submit();
                    }else{
                        return false;
                    }
                }
                
                
             $(document).ready(function(){
             $('.sex select').selectik({width:50,maxItems: 8, minScrollHeight: 20});
             });
             $(document).ready(function(){
             $('.school select').selectik({width:160,maxItems: 16, minScrollHeight: 20});
             });
             $(document).ready(function(){
             $('.department select').selectik({width:160,maxItems: 16, minScrollHeight: 20});
             });
             
             
               window.history.forward(1);    //防止回上頁
           
             
    </script>   
    </body>
</html>