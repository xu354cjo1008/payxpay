<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/partner.css"/>
        <link rel="stylesheet" type="text/css" href="css/selectik.css" />
        <link rel="stylesheet" type="text/css" href="css/match_popup_invite.css" media="screen"/>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="js/jquery.selectik.js"></script>
        <script type="text/javascript" src="js/jquery.match_popup_invite.js"></script>
        <script type="text/javascript" src="js/jquery.tinyscrollbar.min.js"></script>
        <?php include_once("match_identification.php");?>
    </head>
    <body>
        <div id="main">
            <a href="http://localhost/V1/home.php"><img class="logo" src="image/logo.png"></a>            
            <a href="http://localhost/V1/PhpProject8/index.php"><img class="login" src="image/login.png"></a>
            <img class="register" src="image/register.png">
            <img class="menu" src="image/menu.png">
           
            <img class="choose_match" src="image/menu_choose.png">
            <a id="home_text" href="http://localhost/V1/home.php">首頁</a>
            <a id="match_text" href="http://localhost/V1/match.php">即時配對</a>
            <a id="mypage_text" href="http://localhost/V1/mypage.php">我的頁面</a>
            <a id="history_text" href="http://localhost/V1/history.php">我的活動</a>
            <a id="suggest_text" href="http://localhost/V1/suggest.php">推薦行程</a>
            
            <img class="match_condition" src="image/match_condition.png">         
            <img class="match_chatroom" src="image/match_chatroom.png">
            <div id="match_inviting_box">               
            </div>
            <div id="match_teammate_box" class="match_teammate_box">    
            </div>
            <?php 
               session_start(); 
               if($_SESSION['id']==$_SESSION['user_host'] && $_SESSION['user_state']==1)
                  echo' <img id="invite_button" class="match_invite" style="cursor: pointer" src="image/match_invite.png">                      
                        <img id="match_go_button" class="match_go" style="cursor: pointer" src="image/match_go.png">';
               else if($_SESSION['user_state']==2)
                   echo'<img id="match_go_button" class="match_go" title="waiting match">';
            ?>
            
            <form id="match_data_form" name="match_data_form" action="match_go.php" method="post">
                <div class="match_find" id="match_find">
                    <select a id="match_find_select" name="match_find_select">
                        <option value="聯誼">聯誼</option>
                        <option value="出遊">出遊</option>
                        <option value="迎新">迎新</option>
                   </select>
                </div>
                <div class="area" id="self_area">
                    <select a id="self_area_select" onChange="self_school_list_renew(this.selectedIndex);" name="self_area_select">
                        <option value="0">基隆市</option>
                        <option value="1">台北市</option>
                        <option value="2">新北市</option>
                        <option value="3">桃園縣</option>
                        <option value="4">新竹縣</option>
                        <option value="5">新竹市</option>
                        <option value="6">苗栗縣</option>
                        <option value="7">台中市</option>
                        <option value="8">彰化縣</option>
                        <option value="9">雲林縣</option>
                        <option value="10">嘉義縣</option>
                        <option value="11">嘉義市</option>
                        <option value="12">台南市</option>
                        <option value="13">高雄市</option>
                        <option value="14">屏東縣</option>
                        <option value="15">台東縣</option>
                        <option value="16">花蓮縣</option>
                        <option value="17">宜蘭縣</option>
                        <option value="18">南投縣</option>
                        <option value="19">澎湖縣</option>
                        <option value="20">金門縣</option>
                   </select>
                </div>
                <div class="school" id="self_school">
                    <select a id="self_school_select" name="self_school_select">
                        <option value="國立臺灣海洋大學">國立臺灣海洋大學</option>
                        <option value="崇右技術學院">崇右技術學院</option>
                        <option value="經國管理暨健康學院">經國管理暨健康學院</option>
                   </select>
                </div>
                <div class="grade" id="self_grade">
                    <select a  name="self_grade_select">
                        <option value="1">一</option>
                        <option value="2">二</option>
                        <option value="3">三</option>
                        <option value="4">四</option>
                   </select>
                </div>
                <div class="department" id="self_department">
                    <select a name="self_department_select">
                       <option value="文學院">文學院</option>
                        <option value="理學院">理學院</option>
                        <option value="社會科學院">社會科學院</option>
                        <option value="管理學院">管理學院</option>
                        <option value="法律學院">法律學院</option>
                        <option value="工學院" >工學院</option>
                        <option value="電資學院">電資學院</option>
                        <option value="公衛學院">公衛學院</option>
                        <option value="生命科學院">生命科學院</option>
                        <option value="社會科學院">社會科學院</option>
                        <option value="醫學院">醫學院</option>
                        <option value="農學院">農學院</option>
                        <option value="新聞傳播學院">新聞傳播學院</option>
                        <option value="藝術學院">藝術學院</option>
                        <option value="設計學院">設計學院</option>
                   </select>
                </div>
                
                <div class="area" id="match_area" >
                    <select a onChange="match_school_list_renew(this.selectedIndex);" name="match_area_select">
                        <option value="0">基隆市</option>
                        <option value="1">台北市</option>
                        <option value="2">新北市</option>
                        <option value="3">桃園縣</option>
                        <option value="4">新竹縣</option>
                        <option value="5">新竹市</option>
                        <option value="6">苗栗縣</option>
                        <option value="7">台中市</option>
                        <option value="8">彰化縣</option>
                        <option value="9">雲林縣</option>
                        <option value="10">嘉義縣</option>
                        <option value="11">嘉義市</option>
                        <option value="12">台南市</option>
                        <option value="13">高雄市</option>
                        <option value="14">屏東縣</option>
                        <option value="15">台東縣</option>
                        <option value="16">花蓮縣</option>
                        <option value="17">宜蘭縣</option>
                        <option value="18">南投縣</option>
                        <option value="19">澎湖縣</option>
                        <option value="20">金門縣</option>
                   </select>
                </div>
                <div class="school" id="match_school">
                    <select a id="match_school_select" name="match_school_select">
                        <option value="不限">不限</option>
                        <option value="國立臺灣海洋大學">國立臺灣海洋大學</option>
                        <option value="崇右技術學院">崇右技術學院</option>
                        <option value="經國管理暨健康學院">經國管理暨健康學院</option>
                   </select>
                </div>
                <div class="grade" id="match_grade">
                    <select a name="match_grade_select">
                        <option value="0">不限</option>
                        <option value="1">一</option>
                        <option value="2">二</option>
                        <option value="3">三</option>
                        <option value="4">四</option>
                   </select>
                </div>
                <div class="department" id="match_department">
                    <select a name="match_department_select">
                        <option value="不限">不限</option>
                        <option value="電資學院">電資學院</option>
                        <option value="工學院">工學院</option>
                        <option value="文學院">文學院</option>
                        <option value="理學院">理學院</option>
                        <option value="醫學院">醫學院</option>
                        <option value="藝術學院">藝術學院</option>
                   </select>
                </div>          
                <input id="team_number" name="team_number_select" value="0" type="text" min="0" class="team_amuont"/>
                <input id="number" name="match_number_select" value="0" type="text" min="0" class="amuont"/>
            </form>
            <img id="match_chatgo" src="image/match_chatgo.png">
            
       <!---彈跳式邀請介面----------->     
            <div id="element_to_pop_up">
                <form id="friendslist_inviteform" action="match_invite.php" method="post">
                    <input id="friend_list_input_button" class="friend_list_input" type="button" value="發出邀請"/> 
                    <div id="friendslist_scroll">
                        <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                             <div class="viewport">                      
                                 <div id="friendslist_scroll_overview" class="overview"><p id="qqaaq"></p></div>                                
		             </div>              
                    </div> 
                </form>                  
	    </div>
    <!--提示字樣------------------------------------------------------------------------->        
            <style type="text/css">
                  .match_invite_ddmessage{
                       position: absolute;
                        left: 336px;
                        top: 119px;
                        color:#ff3300;
                  }

              </style>
            
             <a id="testaaa" class="match_invite_ddmessage"></a>
          <!----------------------------------------------------------->  
            
         <script type="text/javascript">        
         ///////大學清單  依地區分類////////////////////////////////////////////////////////////////////////    
             school_list=new Array();
             school_list[0]=["國立臺灣海洋大學", "崇右技術學院", "經國管理暨健康學院"];	// 基隆市
             school_list[1]=["國立臺灣大學", "國立政治大學", "國立臺灣師範大學", "國立臺北商業技術學院", "國立臺北科技大學", "國立臺灣科技大學","國立臺北教育大學","臺北市立教育大學","國立陽明大學","臺北市立體育學院","國立臺北藝術大學","國立臺灣戲曲學院","國立臺北大學","國立臺北護理健康大學","國防大學","國防醫學院"
                             ,"東吳大學","銘傳大學","實踐大學","世新大學","大同大學","中國文化大學","臺北醫學大學","中國科技大學","中華科技大學","臺北城市科技大學","德明財經科技大學","台北海洋技術學院"];	// 台北市
             school_list[2]=["國立臺北大學", "國立臺灣藝術大學", "輔仁大學學校財團法人輔仁大學", "淡江大學","華梵大學","真理大學","馬偕醫學院","法鼓佛教學院","臺北基督學院","明志科技大學","聖約翰科技大學","景文科技大學","東南科技大學","致理技術學院","醒吾科技大學","亞東技術學院","德霖技術學院","黎明技術學院","華夏技術學院","國立空中大學"];			// 動機系
             school_list[3]=["國立中央大學", "國立體育大學", "中原大學","長庚大學","元智大學","開南大學","龍華科技大學","健行學校財團法人健行科技大學","萬能學校財團法人萬能科技大學","長庚學校財團法人長庚科技大學","桃園創新技術學院","國防大學","中央警察大學"];				// 工科系
             school_list[4]=["國立交通大學","明新科技大學"];
             school_list[5]=["國立清華大學","國立新竹教育大學","中華大學","玄奘大學","元培科技大學"];
             school_list[6]=["國立聯合大學","廣亞學校財團法人育達商業科技大學","亞太學校財團法人亞太創意技術學院"];
             school_list[7]=["國立中興大學","國立臺中教育大學","國立臺灣體育運動大學","東海大學","逢甲大學","靜宜大學","中山醫學大學","中國醫藥大學","亞洲大學","國立勤益科技大學","國立臺中科技大學","朝陽科技大學","弘光科技大學","嶺東科技大學","中臺科技大學","僑光科技大學","修平學校財團法人修平科技大學"];
             school_list[8]=["國立彰化師範大學","大葉大學","明道學校財團法人明道大學","建國科技大學","中州學校財團法人中州科技大學"];
             school_list[9]=["國立雲林科技大學","國立虎尾科技大學","環球學校財團法人環球科技大學"];
             school_list[10]=["國立中正大學","南華大學","稻江科技暨管理學院","吳鳳科技大學"];
             school_list[11]=["國立嘉義大學","大同技術學院"];
             school_list[12]=["國立成功大學","國立臺南藝術大學","國立臺南大學","長榮大學","康寧學校財團法人康寧大學","台灣首府學校財團法人台灣首府大學","興國管理學院","南台科技大學","崑山科技大學","嘉南藥理科技大學","台南家專學校財團法人台南應用科技大學","遠東科技大學","中華醫事科技大學","南榮技術學院"];
             school_list[13]=["國立中山大學","國立高雄師範大學","國立高雄大學","義守大學","高雄醫學大學","國立高雄第一科技大學","國立高雄應用科技大學","國立高雄海洋科技大學","國立高雄餐旅大學","樹德科技大學","輔英科技大學","正修科技大學","高苑科技大學","文藻外語學院","和春技術學院","東方學校財團法人東方設計學院","高雄市立空中大學","中華民國陸軍軍官學校","海軍軍官學校","中華民國空軍官校","國立空軍航空技術學院"];
             school_list[14]=["國立屏東教育大學","國立屏東科技大學","大仁科技大學","美和學校財團法人美和科技大學","永達技術學院","高鳳數位內容學院","國立屏東商業技術學院"];
             school_list[15]=["國立臺東大學"];
             school_list[16]=["國立東華大學","大漢技術學院","慈濟技術學院","臺灣觀光學院","慈濟學校財團法人慈濟大學"];
             school_list[17]=["國立宜蘭大學","佛光大學","蘭陽技術學院"];
             school_list[18]=["國立暨南國際大學","南開科技大學"];
             school_list[19]=["國立澎湖科技大學"];
             school_list[20]=["國立金門大學"];
             //選擇地區後  更新學校清單
             function self_school_list_renew(index){
	        for(var i=0;i<school_list[index].length;i++)
                {
                    document.match_data_form.self_school_select.options[i]=new Option(school_list[index][i], school_list[index][i]);	// 設定新選項
                }
	     document.match_data_form.self_school_select.length=school_list[index].length;	// 刪除多餘的選項
             $("#self_school_select").data('selectik').refreshCS();
             $('#self_school_select').data('selectik').changeCS({index: 1}); 
             }
             function match_school_list_renew(index){
	        for(var i=0;i<school_list[index].length;i++)
                {
                    document.match_data_form.match_school_select.options[i+1]=new Option(school_list[index][i], school_list[index][i]);	// 設定新選項
                }
	     document.match_data_form.match_school_select.length=school_list[index].length+1;	// 刪除多餘的選項
             $("#match_school_select").data('selectik').refreshCS();
             $('#match_school_select').data('selectik').changeCS({index: 1}); 
             }
    ////////////////////////////////////////////////////////////////////////////////////////////////////
             $(document).ready(function(){
             $('.area select').selectik({width:121,maxItems: 8, minScrollHeight: 20});
             });
             $(document).ready(function(){
             $('.match_find select').selectik({width:100,maxItems: 8, minScrollHeight: 20});
             });
             $(document).ready(function(){
             $('.school select').selectik({width:165,maxItems: 8, minScrollHeight: 20});
             });
             $(document).ready(function(){
             $('.grade select').selectik({width:64,maxItems: 8, minScrollHeight: 20});
             });
             $(document).ready(function(){
             $('.department select').selectik({width:127,maxItems: 8, minScrollHeight: 20});
             });       
             $(document).ready(function(){
                     $('#friendslist_scroll').tinyscrollbar();	
             });
             //讓text只能輸入數字
             $(document).ready(function(){
                $(".team_amuont").keydown(function(event) {
                    // Allow: backspace, delete, tab, escape, and enter
                    if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
                         // Allow: Ctrl+A
                        (event.keyCode == 65 && event.ctrlKey === true) || 
                         // Allow: home, end, left, right
                        (event.keyCode >= 35 && event.keyCode <= 39)) {
                             // let it happen, don't do anything
                             return;
                    }
                    else {
                        // Ensure that it is a number and stop the keypress
                        if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                            event.preventDefault(); 
                        }   
                    }
                });
                $(".amuont").keydown(function(event) {
                    // Allow: backspace, delete, tab, escape, and enter
                    if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
                         // Allow: Ctrl+A
                        (event.keyCode == 65 && event.ctrlKey === true) || 
                         // Allow: home, end, left, right
                        (event.keyCode >= 35 && event.keyCode <= 39)) {
                             // let it happen, don't do anything
                             return;
                    }
                    else {
                        // Ensure that it is a number and stop the keypress
                        if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                            event.preventDefault(); 
                        }   
                    }
                });
            });
             /////////////////////////////////////////////////////////////////////////////////////////////////////
             //讀出好友名單
             $(document).ready(function(){
                $("#invite_button").click(function(){
                    $.ajax({
                        //contentType: "application/json",
                         url: 'getfriendslist.php',
                         dataType: 'json',
                             type:'POST',
                             cache: false,
                         error: function(xhr) {
                         },
                         success: function(response) {
                            var numberoffriends=response.length;
                            var verticalnum;
                            var horizationnum;
                            var top;
                            var left;
                            var div ;
                            $("#friendslist_scroll_overview").empty();                 //清空原有的元素 重新整理資訊
                            for(var i=0;i<numberoffriends;i++)
                            {   //將每一個frame排列貼至頁面 再將名稱相片等資訊貼在frame上
                                verticalnum=Math.floor(i/5);
                                horizationnum=i%5;
                                top = verticalnum*157 + 7 + "px";
                                left = 126*horizationnum + 6 + "px";
                                div = $("<div>", {id:"friendslist_"+response[i][0],class:"friend_list_frame"});
                                $("#friendslist_scroll_overview").append(div);
                                $("#friendslist_"+response[i][0]+".friend_list_frame").css( {
                                    'position': 'absolute',
                                    'left': left,
                                    'top': top
                                });              
                                $("#friendslist_"+response[i][0]+".friend_list_frame")
                                    .append('<h class="friend_list_name">'+response[i][1]+'</h>');         
                                $("#friendslist_"+response[i][0]+".friend_list_frame")
                                    .append(
                                       $(document.createElement('input')).attr({
                                           class: 'friend_list_checkbox'
                                           ,name:  'match_invite[]'
                                          ,value: response[i][0]
                                          ,type:  'checkbox'
                                       })
                                    );                       
                             };
                         }
                     });
                });
             });
             //////////////////////////////////////////////////////////////////////////////////////////////
             //送出match邀請
             $(document).ready(function(){
                $("#friend_list_input_button").click(function(){
                    $.ajax({
                         url: 'match_invite.php',
                         type:'POST',
                         cache: false,
                         data: $('#friendslist_inviteform').serialize(),
                         
                         error: function(xhr) {
                         },
                         success: function(response) {
                         }
                     });
                     //讀出checked的ID與其他資訊  放入inviting的box裡面
                     var goinvitingid=$('#friendslist_scroll_overview input:checked');
                     var goinvitingname;
                     var offset,object;
                     var invitingnumber=$("#match_inviting_box").children('.match_inviting_box_photo').length;      //讀出目前邀請中人數
                     $('#friendslist_scroll_overview input:checked').each(function(index)                           //將每一筆資訊放置inviting box最後面
                     {
                         goinvitingname=$('#friendslist_'+$(goinvitingid[index]).val()).children('.friend_list_name').text();                   
                         offset=30+(index+invitingnumber)*100+"px";
                         object = $("<img>", {id:"match_inviting_list_"+$(goinvitingid[index]).val(),class:"match_inviting_box_photo",title:goinvitingname});

                         $("#match_inviting_box").append(object);
                         $("#match_inviting_list_"+$(goinvitingid[index]).val()).css( {
                             'position': 'absolute',
                             'top' : offset
                         });  
                     });                    
                     $("#friendslist_scroll_overview :checked").each(function() {  //刪除邀請過後的名單   可刪 因為叫出名單的時候會刪
                        $(this).parent().remove(); 
                     });
                });
             });
             /////開始配對///////////////////////////////////////////////////////////////////////////////////////////////////////////
            $(document).ready(function(){
                $("#match_go_button").click(function(){
                    $.ajax({
                         url: 'match_go.php',
                         type:'POST',
                         data: $('#match_data_form').serialize(),
                         cache: false,
                         error: function(xhr) {
                         },
                         success: function(response) {
                             if(response==0)
                                $("#testaaa").text("等待配對");
                             else
                                 $("#testaaa").text("配對成功");
                         }
                     });
                     $("#match_inviting_box").empty();   //清空正在邀請的欄位
                });
             });
             ///////////////////////////////////////////////////////////////////////////////////////
             $(document).ready(function(){
                getteammatelist();
                getinvitinglist();
                getnewmessage();
             });
             //檢查隊伍名單並顯示
             function getteammatelist() 
                {$("#testaaa").text($($("#match_teammate_box").children().eq(0)).attr('id'));
                    $.ajax({
                         url: 'getteammatelist.php',
                         dataType: 'json',
                             type:'POST',
                             async: false,
                             cache: false,
                        // data: { name: $('#name').val()},
                         error: function(xhr) {
                         },
                         success: function(response) {
                         var offset;
                         var object;
                            $("#match_teammate_box").empty();
                            for(var i=0;i<response.length;i++)
                            {
                                offset=i*65+"px";
                                object = $("<img>", {id:"teammatelist_"+response[i][0],class:"match_teammate_box_photo",title:response[i][1]});
                                $("#match_teammate_box").append(object);
                               $("#teammatelist_"+response[i][0]).css( {
                                    'position': 'absolute',
                                    'left': offset
                                });  
                            }
                         }
                });
                }
                //檢查正在邀請的名單並顯示
                function getinvitinglist() 
                {
                    $.ajax({
                         url: 'getinvitinglist.php',
                         dataType: 'json',
                             type:'POST',
                             async: false,
                             cache: false,
                        // data: { name: $('#name').val()},
                         error: function(xhr) {
                         },
                         success: function(response) {
                             var offset;
                             var object;
                                $("#match_inviting_box").empty();
                                for(var i=0;i<response.length;i++)
                                {
                                    offset=30+i*100+"px";
                                    object = $("<img>", {id:"match_inviting_list_"+response[i][0],class:"match_inviting_box_photo",title:response[i][1]});                                   
                                    $("#match_inviting_box").append(object);
                                    $("#match_inviting_list_"+response[i][0]).css( {
                                        'position': 'absolute',
                                        'top' : offset
                                    });  
                                }
                         }
                });
                }    

    //////////////////////////////long polling for invitemessagecheck-///////////////////////////////////////
      function getnewmessage(){
        (function poll(){
            $.ajax({ url: "invitemessagecheck.php", cache: false ,success: function(response){
                for(var i=0;i<response.length;i++)
                {
                    if(response[i][2]==0)              //收到邀請信
                    {
                        $("#testaaa").text("有新邀請");
                    }
                    if(response[i][2]==1)
                    {//收到邀請確認訊息 把邀請中的人移至隊友名單
                        $("#match_inviting_list_"+response[i][0]).remove();                               //刪除名字
                        var inviting_element=$("#match_inviting_box").children('.match_inviting_box_photo');
                        inviting_element.each(function(idy, val){          //重新排列
                           $(this).css('top',30+idy*100+'px');
                        });                           
                        var object = $("<img>", {id:"teammatelist_"+response[i][0],class:"match_teammate_box_photo",title:response[i][1]});   //新增名字
                        $("#match_teammate_box").append(object);
                        var teammate_element=$("#match_teammate_box").children('.match_teammate_box_photo');
                        $("#teammatelist_"+response[i][0]).css( {
                            'position': 'absolute',
                            'left': (teammate_element.length-1)*65+"px"
                        });  
                    }
                    if(response[i][2]==2)
                    {   //收到退出信息  假如是隊長退出 則隊友跳回match_start頁面  否則刪除退出隊伍的隊友
                        if("teammatelist_"+response[i][0]==$($("#match_teammate_box").children().eq(0)).attr('id'))
                        {
                            window.location.href='match_start.php';
                        }else{$("#testaaa").text('aaaaaaaaaaaaaaaa');
                            $("#match_inviting_box").children(".match_inviting_box_photo").each((function(index){ 
                                if("match_inviting_list_"+response[i][0]==$(this).attr('id'))                 //比對id 並刪除比對成功的名單
                                {
                                    $("#match_inviting_list_"+response[i][0]).remove();
                                }
                            }));
                            $("#match_inviting_box").children('.match_inviting_box_photo').each((function(index){  //重新排列
                                $(this).css('top',30+index*100+'px');
                            }));
                            $("#match_teammate_box").children(".match_teammate_box_photo").each((function(index){ $("#testaaa").text('bbbbbbbb');
                                if("teammatelist_"+response[i][0]==$(this).attr('id'))                 //比對id 並刪除比對成功的名單
                                {
                                    $("#teammatelist_"+response[i][0]).remove();
                                }
                            }));
                            $("#match_teammate_box").children('.match_teammate_box_photo').each((function(index){  //重新排列
                                $(this).css('left',index*65+'px');
                            }));
                        }
                    }
                    if(response[i][2]==3)    //隊長新邀請人
                    {
                        getinvitinglist();
                    }
                    if(response[i][2]==4)    //配對失敗 等待配對
                    {
                         if($("#invite_button"))
                            $("#invite_button").remove();
                         if($("#match_go_button"))
                            $("#match_go_button").remove();
                         $("#main").append($("<img>", {id:"match_go_button",class:"match_go",title:"waiting match"}));
                    }
                    if(response[i][2]==5)   //配對成功 跳轉頁面
                    {
                        window.location.href='matching.php';
                    }
                }
            }, dataType: "json", complete: poll, timeout: 30000 });
        })();
        }
    </script>
    <!--------------------------------------------------------------------------------------------------------->
    </body>
</html>