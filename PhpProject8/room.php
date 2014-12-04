<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">   
       <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
     <script type="text/javascript">
       //mail=new Array();
$(document).ready(function () { 
setInterval("newmailcheck()",1000); 
$("#invitenameForm").click(function()
{
    $("#myForm").toggle();
    $('#invitenameForm').text("有人邀請你喔");
});

mailcheck();
}); 


function mailcheck() 
{
    $.ajax({
         url: 'mailcheck.php',
         dataType: 'json',
             type:'POST',
        // data: { name: $('#name').val()},
         error: function(xhr) {
          // alert('Ajax request 發生錯誤');
          document.getElementById('invitename').options.length = 0;
         },
         success: function(response) {
     
           
//           for(var i=0;i<response.length/2;i++)
//               {
//                   if(document.myForm.invitename.options[i].value!=response)
//               }
             //document.getElementById('invitename').options.length = 0;
           for(var i=0;i<response.length/2;i++)
               {
                   if(response[2*i+1]=='invite')
		      document.myForm.invitename.options[i]=new Option(response[response.length-2*i-2], response[response.length-2*i-2]);	// 設定新選項             
               }             
	   document.myForm.invitename.length=response.length;	// 刪除多餘的選項}
           if(response.length>0)
               $('#invitenameForm').text("有人邀請你喔");   
         }
         
});
}
function newmailcheck() 
{
    $.ajax({
         url: 'newmailcheck.php',
         dataType: 'json',
             type:'POST',
        // data: { name: $('#name').val()},
         error: function(xhr) {
           //alert('Ajax request 發生錯誤');
         },
         success: function(response) {
                mailcheck();
         }
         
});
}
function teammatecheck()
{
    $.ajax({
         url: 'teammatecheck.php',
         dataType: 'json',
             type:'POST',
        // data: { name: $('#name').val()},
         error: function(xhr) {
          // alert('Ajax request 發生錯誤');
         },
         success: function(response) {

         }
});
}
function check()
{
    if(document.myForm.invitename.value=='')
        alert("未選擇");
    else
       document.myForm.submit();   
}


         </script>
        <title></title>
    </head>
    <body>
        <?php
        
        session_start();    
        ////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_SESSION['username'])) {   
            //session更新
           include_once("logdata.php");
           $con = mysqli_connect($dbhost, $dbuser, $dbpass);
           mysqli_select_db($con,$dbname);
           $sql = "SELECT * FROM user WHERE id ='".$_SESSION['id']."'";
           $res = mysqli_query($con,$sql) or die(mysql_error());
           $rows = mysqli_fetch_assoc($res);
           $_SESSION['state'] = $rows['state'];
           $_SESSION['roomhost'] = $rows['roomhost'];
        //   mysqli_close($con);
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////      
           if($_SESSION['state']=='0'){//if 沒有房間
               echo "</br/>" . '<form action = "buildroom.php" method = "get">
                <input type = "submit" name = "buildroom" value = "開房間"></form>';

           }else{//if 有房間
               /*-----------------共同顯示  隊友 退房 -------------------------------*/
                  $sql = "SELECT * FROM user WHERE id ='".$_SESSION['roomhost']."'";
                 $res = mysqli_query($con,$sql) or die(mysqli_error($con));
                 $rows = mysqli_fetch_assoc($res);
                 echo '<p>隊長: '.$rows['username'].'</p>';
                 $sql = "SELECT * FROM user WHERE roomhost ='".$_SESSION['roomhost']."'";
                 $res = mysqli_query($con,$sql) or die(mysqli_error($con));
               //  $_SESSION['teamnumber']=0;
                 while($record = mysqli_fetch_array($res)){
                    // $_SESSION['teamnumber']++;
                     if($record['id']!=$record['roomhost'])
                        echo '<p>隊員: '.$record['username'].'</p>';
                   }
                //退房按鈕 跳room.php
                echo  "</br/>" . '<form action = "roomout.php" method = "get">
                 <input type = "submit" name = "roomout" value = "退房間"></form>';
         /*-----------------------------------------------------------------------------------------*/  
               if($_SESSION['state']=='1'){//if 有房間 等待隊友加入
                   if ($_SESSION['id']==$_SESSION['roomhost']){//if 房主
                      //讀取好友資料 跳 invit.php
                      $sql = "SELECT * FROM user";
                      $res = mysqli_query($con,$sql) or die(mysql_error());
                      echo '邀請好友
                      <form id="form1" name="form1" method="post" action="invite.php">
                      <select name="invite">
                      <option value=""></option>';
                      while($record = mysqli_fetch_array($res)){
                          if($record['roomhost']!=$_SESSION['id'])
                          {
                              if($record['state']=='0')
                                  echo "<option  value='".$record['id']."'>".$record['username']."</option>" ;
                              else
                                  echo "<option  value='".$record['id']."'>".$record['username']." 正在別的房間</option>" ;
                          }
                      }
                      echo'</select><input type="submit" />';
                      echo'</form>';
                      mysqli_close($con);
                      //輸入搜尋資料 按下按鈕後開始配對
                      echo'
                     <form action="match.php" method="post">輸入隊伍資訊<br />
                     輸入隊伍人數: <input type="value" name="number" /><br />
                     <select name="area">
                       <option value ="台北">台北</option>
                       <option value ="新竹">新竹</option>
                       <option value ="台中">台中</option>
                    </select>  
                    <select name="school">
                       <option value ="台大">台大</option>
                       <option value ="政大">政大</option>
                       <option value ="師大">師大</option>
                    </select>
                    <select name="department">
                       <option value ="電機">電機</option>
                       <option value ="企管">企管</option>
                       <option value ="外文">外文</option>
                       <option value ="音樂">音樂</option>
                    </select> 
                     <select name="grade">
                       <option value ="1">一年級</option>
                       <option value ="2">二年級</option>
                       <option value ="3">三年級</option>
                       <option value ="4">四年級</option>
                    </select> 
                    <br />輸入搜尋資訊<br />搜尋項目
                    <select name="find">
                       <option value ="0">聯誼</option>
                       <option value ="1">迎新</option>
                       <option value ="2">出遊</option>
                    </select>  <br />
                    
                    人數<select name="searchnumber">
                       <option value ="不限">不限</option>
                       <option value ="1">正負1</option>
                       <option value ="2">正負2</option>
                       <option value ="3">正負3</option>
                    </select>  
                     <select name="searcharea">
                       <option value ="不限">不限</option>
                       <option value ="台北">台北</option>
                       <option value ="新竹">新竹</option>
                       <option value ="台中">台中</option>
                    </select>  
                    <select name="searchschool">
                       <option value ="不限">不限</option>
                       <option value ="台大">台大</option>
                       <option value ="政大">政大</option>
                       <option value ="師大">師大</option>
                    </select>
                    <select name="searchdepartment">
                       <option value ="不限">不限</option>
                       <option value ="電機">電機</option>
                       <option value ="企管">企管</option>
                       <option value ="外文">外文</option>
                       <option value ="音樂">音樂</option>
                    </select> 
                     <select name="searchgrade">
                       <option value ="0">不限</option>
                       <option value ="1">一年級</option>
                       <option value ="2">二年級</option>
                       <option value ="3">三年級</option>
                       <option value ="4">四年級</option>
                    </select> 
                    <input type="submit" />
                    </form>';
                 }else{
                 }   
               }else if ($_SESSION['state']=='2'){
                   echo '等待配對';
               }else if ($_SESSION['state']=='3'){
                   echo '配對成功';
               }

           }
        }else{   
            header("location:index.php");  
                }
                
        ?>

         <!--------------------------------------------------------------------------------->
         <p id="invitenameForm"></>

             <?php 
             if($_SESSION['id']==$_SESSION['roomhost'])  
             {  echo'    
                 <form id="myForm" name="myForm" style="display:none" action="join.php" method="post", disabled="disabled">
                    <select id="invitename" name="invitename" size=5 , disabled="disabled">
	               <!--<option value="">-->
                   </select>
                   已在房間中<input type="submit" disabled="disabled" />';
             }else{
                     echo'       
                     <form id="myForm" name="myForm" style="display:none" action="join.php" method="post">
                         <select id="invitename" name="invitename" size=5>
	                     <!--<option value="">-->
                          </select>
                     <input type="button" value="接受邀請" onClick="check()"/>';
             }
                 ?>
         </form>
        <!--測試   時鐘  -->
   
            <input type="text" id="clock">
            <script language=javascript>
var int=self.setInterval(function(){clock()},1000);
function clock()
  {
  var d=new Date();
  var t=d.toLocaleTimeString();
  document.getElementById("clock").value=t;
  }
</script>


    </body>
</html>
