<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/partner.css"/>
        <link rel="stylesheet" type="text/css" href="css/match_popup_invite.css" media="screen"/>
        <?php include_once 'matching_identification.php'; ?>;
    </head>
    <body>
        <div id="main">
            <a href="http://localhost/V1/home.php"><img class="logo" src="image/logo.png"></a>
            <img class="login" src="image/login.png">
            <img class="register" src="image/register.png">
            <img class="menu" src="image/menu.png">
            <img class="choose_match" src="image/menu_choose.png">
            <a id="home_text" href="http://localhost/V1/home.php">首頁</a>
            <a id="match_text" href="http://localhost/V1/match.php">即時配對</a>
            <a id="mypage_text" href="http://localhost/V1/mypage.php">我的頁面</a>
            <a id="history_text" href="http://localhost/V1/history.php">我的活動</a>
            <a id="suggest_text" href="http://localhost/V1/suggest.php">推薦行程</a>
            
            <?php include_once 'get_matching_information.php'; ?>
            <div class="matching_man">
                <?php
                    echo '</br></br>';
                    echo $matching_info['school2'].'</br>';
                    echo $matching_info['department2'].'</br>';
                    echo $matching_info['grade2'].'年級</br>';
                 ?>
            </div>
            <div class="matching_woman">
                <?php
                    echo '</br></br>';
                    echo $matching_info['school1'].'</br>';
                    echo $matching_info['department1'].'</br>';
                    echo $matching_info['grade1'].'年級</br>';
                ?>
            </div>
            <div class="matching_team1">
                <?php
                   echo '<img id="matching_member_captain_"'.$matching_member_man[0][0].' class="matching_team_captain_left" title="隊長" src="image/match_icon_captain.png">';
                   for($i=0;$i<count($matching_member_man);$i++)
                   {
                       echo '<div id="matching_member_div_"'.$matching_member_man[$i][0].' class="matching_team_list">';
//                       echo '<img id="matching_member_captain_"'.$matching_member_woman[$i][0].' class="matching_team_captain" title="隊長" src="image/match_icon_captain.png">';
                       echo '<img id="matching_member_photo_"'.$matching_member_man[$i][0].' class="matching_team_photo" title='.$matching_member_man[$i][1].'>';
                       echo '<p id="matching_member_name_"'.$matching_member_man[$i][0].' class="matching_team_name" value='.$matching_member_man[$i][1].'>'.$matching_member_man[$i][1].'</h>';
                       echo '</div>';
                   }
                ?>
            </div>
            <div class="matching_team2">
                <?php
                   echo '<img id="matching_member_captain_"'.$matching_member_woman[0][0].' class="matching_team_captain_right" title="隊長" src="image/match_icon_captain.png">';
                   for($i=0;$i<count($matching_member_woman);$i++)
                   {
                       echo '<div id="matching_member_div_"'.$matching_member_woman[$i][0].' class="matching_team_list">';
//                       echo '<img id="matching_member_captain_"'.$matching_member_woman[$i][0].' class="matching_team_captain" title="隊長" src="image/match_icon_captain.png">';
                       echo '<img id="matching_member_photo_"'.$matching_member_woman[$i][0].' class="matching_team_photo" title='.$matching_member_woman[$i][1].'>';
                       echo '<p id="matching_member_name_"'.$matching_member_woman[$i][0].' class="matching_team_name" value='.$matching_member_woman[$i][1].'>'.$matching_member_woman[$i][1].'</h>';
                       echo '</div>';
                   }
                ?>
            </div>
            <img class="matching_chatroom" src="image/match_chatroom2.png">
            <img class="matching_chatgo" src="image/match_chatgo.png"
        </div>
    </body>
</html>