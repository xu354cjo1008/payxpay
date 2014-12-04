<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/partner.css"/>
        <link rel="stylesheet" type="text/css" href="css/match_popup_invite.css"/>
        <!--<link rel="stylesheet" type="text/css" href="css/Tiny_Scrollbar.css"/>-->
        <link rel="stylesheet" type="text/css" href="css/selectik.css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="js/jquery.selectik.js"></script>
        <!--<script type="text/javascript" src="js/jquery.tinyscrollbar.min.js"></script>-->
         <?php include_once("match_start_identification.php");?>
       
    </head>
    <body>
        <div id="main">
            <a href="http://localhost/V1/home.php"><img class="logo" src="image/logo.png"></a>
            <a href="http://localhost/V1/PhpProject8/index.php"><img class="login" src="image/login.png"></a>
            <img class="register" src="image/register.png">
            <img class="menu" src="image/menu.png">
           
            <img class="choose_match" src="image/menu_choose.png">
            <a id="home_text" href="http://localhost/V1/home.php">首頁</a>
            <a id="match_text" href="http://localhost/V1/match_start.php">即時配對</a>
            <a id="mypage_text" href="http://localhost/V1/mypage.php">我的頁面</a>
            <a id="history_text" href="http://localhost/V1/history.php">我的活動</a>
            <a id="suggest_text" href="http://localhost/V1/suggest.php">推薦行程</a>
            <div id="match_home" >
                <img src='image/match_home.png'/>
            </div>
           
            
            <form id="build_match_build_room" action = "build_match_team.php" method = "get">
               <input type="image"  alt="Submit" src="image/match_homebox.png" name = "build_match_team" value = "創建隊伍" title="創建隊伍">
            </form>
              
            <div id="match_invite_box" class='match_invite_box'>
                <form id='match_invite_form' name='match_invite_form' action = "match_invite_accept.php" method = "post">
                    <input type="hidden" id="program_type" name="program_type" value="" />
                    <?php
                       include_once 'invitemessage_read.php';
                       if(count($invite_list)>0)
                       {
                           foreach ($invite_list as $key =>$value) {
                               if($value[2]==0)
                               {
                                   $number=$key%3+1;
                                    echo'<div id="match_invite_list_'.$value[0].'" class="match_invite_list_'.$number.'">';
                                    echo'<img class="match_invite_list_photo" title="'.$value[1].'"/>';
                                    echo'<h class="match_invite_list_name" value='.$value[1].'>'.$value[1].'</h>';
                                    echo'<h class="match_invite_list_message">邀請你</h>';
                                    echo'<input class="match_invite_list_yes" type="image" src="image/match_home_inviteyes.png" alt="Submit" value="確認" data-program-type='.$value[0].'/>';
                                    echo'<input class="match_invite_list_no" type="image" src="image/match_home_inviteno.png" alt="取消" value="取消" data-program-type='.$value[0].'/>';
                                    echo'</div>';
                               }
                            }
                       }
                    ?>
                </form>  
            </div>


              <!--<p id='asdasd'>asdasdad</p>-->
              

              
              
            <script type="text/javascript">
                 $(document).ready(function(){
                     getnewmessage();  
                 });
                 $(document).ready(function(){
                    $(document).on('click', '.match_invite_list_yes',function(e){
                        e.preventDefault(); // Stall form submit
                        $('#program_type').val($(this).data('program-type'));
                        $(this).parents('#match_invite_form:first').submit(); // Submit form
                    }); 
                 });
                $(document).ready(function(){
                    $(document).on('click', '.match_invite_list_no',function(e){
                        e.preventDefault(); // Stall form submit
                        var delete_id=parseInt($(this).data('program-type'));
                        $('#match_invite_list_'+delete_id).remove();
                        $.ajax({
                             url: 'delete_invite_message.php',
                             type:'POST',
                             data: {'delete_id': delete_id},
                             cache: false,
                             error: function(xhr) {
                             },
                             success: function(response) {
                             }
                     });
                    }); 
                 });
                ////---------long polling for invitemessagecheck-----------------------------------------------------------
              function getnewmessage(){  
                  (function poll(){
                    $.ajax({ url: "invitemessagecheck.php", cache: false, success: function(response){                   
                       for(var i=0;i<response.length;i++)
                            {   
                                var match_invite_box_length=$("#match_invite_box").children('div').length;
                                var box_imge_number=match_invite_box_length%3+1;
                                if(response[i][2]==0)
                                    {
                                         var div = $("<div>", {id:"match_invite_list_"+response[i][0],class:"match_invite_list_"+box_imge_number});
                                         $("#match_invite_form").append(div);
                                         $("#match_invite_list_"+response[i][0]).append('<img class="match_invite_list_photo" title="'+response[i][1]+'"/>');
                                         $("#match_invite_list_"+response[i][0]).append('<h class="match_invite_list_name" value='+response[i][1]+'>'+response[i][1]+'</h>');
                                         $("#match_invite_list_"+response[i][0]).append('<h class="match_invite_list_message">邀請你</h>');
                                         $("#match_invite_list_"+response[i][0]).append('<input class="match_invite_list_yes" type="image" src="image/match_home_inviteyes.png" alt="Submit" value="確認" data-program-type='+response[i][0]+'/>');
                                         $("#match_invite_list_"+response[i][0]).append('<input class="match_invite_list_no" type="image" src="image/match_home_inviteno.png"  value="取消" title="取消" data-program-type='+response[i][0]+'/>');
                                     }
                                if(response[i][2]==2)
                                {//收到退出信息 則刪除ooption
                                     $("#match_invite_list_"+response[i][0]).remove();
                                }
                            }
                    }, dataType: "json", complete: poll, timeout: 30000 });
                })();              
                }
                function delete_invite_message(){
                     $.ajax({
                         url: 'delete_invite_message.php',
                         type:'POST',
                         data: {delete_id: delete_id},
                         cache: false,
                         error: function(xhr) {
                         },
                         success: function(response) {
                         }
                     });
                }
            </script>
    <!--------------------------------------------------------------------------------------------------------->

    </body>
</html>