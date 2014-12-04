<?php
        $dbhost = '127.0.0.1';
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'partnera';
        $con = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection'); 
        mysqli_query($con,"set names 'UTF8' ");
        mysqli_select_db($con,$dbname);
        session_start();
        //開始配對 刪除等待中的邀請
        $sql = "DELETE FROM invite_message WHERE sender = '".$_SESSION['id']."' AND content=0 ";
        mysqli_query($con,$sql) or die(mysqli_error($con)); 
        //依照搜索條件開始搜尋
         if($_SESSION['user_sex']=='0')
             $searchsex='1';
         else
             $searchsex='0';
         $search_number_max=$_POST['team_number_select']+$_POST['match_number_select'];
         $search_number_min=$_POST['team_number_select']-$_POST['match_number_select'];
         if($_POST['match_school_select']=='不限'){
             if($_POST['match_department_select']=='不限'){
                 if($_POST['match_grade_select']=='0'){
                     $sql = "SELECT * FROM searching_match WHERE sex ='".$searchsex."'AND find='".$_POST['match_find_select']."'
                             AND self_area='".$_POST['match_area_select']."'
                             AND self_number BETWEEN '".$search_number_min."' AND '".$search_number_max."'";
                     $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
                 }
                 else{
                     $sql = "SELECT * FROM searching_match WHERE sex ='".$searchsex."'
                             AND self_area='".$_POST['match_area_select']."'
                             AND self_grade='".$_POST['match_grade_select']."'
                             AND find='".$_POST['find']."'
                             AND self_number BETWEEN '".$search_number_min."' AND '".$search_number_max."'";
                     $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
                 }
             }else{
                 if($_POST['match_grade_select']=='0'){
                     echo "asd";
                     $sql = "SELECT * FROM searching_match WHERE sex ='".$searchsex."'AND find='".$_POST['match_find_select']."'
                             AND self_area='".$_POST['match_area_select']."'
                             AND self_department='".$_POST['match_department_select']."'
                             AND self_number BETWEEN '".$search_number_min."' AND '".$search_number_max."'";
                     $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
                 }
                 else{
                     $sql = "SELECT * FROM searching_match WHERE sex ='".$searchsex."'
                             AND self_area='".$_POST['match_area_select']."'
                             AND self_department='".$_POST['match_department_select']."'
                             AND self_grade='".$_POST['match_grade_select']."'
                             AND find='".$_POST['find']."'
                             AND self_number BETWEEN '".$search_number_min."' AND '".$search_number_max."'";
                     $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
                 }
                 
             }
         }else{
             if($_POST['match_department_select']=='不限'){
                 if($_POST['match_grade_select']=='0'){
                     $sql = "SELECT * FROM searching_match WHERE sex ='".$searchsex."'AND find='".$_POST['match_find_select']."'
                             AND self_area='".$_POST['match_area_select']."'
                             AND self_school='".$_POST['match_area_select']."'
                             AND self_number BETWEEN '".$search_number_min."' AND '".$search_number_max."'";
                     $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
                 }else{
                     $sql = "SELECT * FROM searching_match WHERE sex ='".$searchsex."'AND find='".$_POST['match_find_select']."'
                             AND self_area='".$_POST['match_area_select']."'
                             AND self_school='".$_POST['match_area_select']."'
                             AND self_grade='".$_POST['match_grade_select']."'
                             AND self_number BETWEEN '".$search_number_min."' AND '".$search_number_max."'";
                     $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
                 }
             }else{
                 if($_POST['match_grade_select']=='0'){
                     $sql = "SELECT * FROM searching_match WHERE sex ='".$searchsex."'AND find='".$_POST['match_find_select']."'
                             AND self_area='".$_POST['match_area_select']."'
                             AND self_school='".$_POST['match_area_select']."'
                             AND self_department='".$_POST['match_department_select']."'
                             AND self_number BETWEEN '".$search_number_min."' AND '".$search_number_max."'";
                     $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
                 }else{
                     $sql = "SELECT * FROM searching_match WHERE sex ='".$searchsex."'AND find='".$_POST['match_find_select']."'
                             AND self_area='".$_POST['match_area_select']."'
                             AND self_school='".$_POST['match_area_select']."'
                             AND self_department='".$_POST['match_department_select']."'    
                             AND self_grade='".$_POST['match_grade_select']."'
                             AND self_number BETWEEN '".$search_number_min."' AND '".$search_number_max."'";
                     $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
                 } 
             
             }
         }
         //將搜索到的名單 其搜索條件與自身條件做比對
         while($record = mysqli_fetch_array($res)){
             if($record['search_school']=='不限'){
                 if($record['search_department']=='不限'){
                     if($record['search_grade']=='0'){
                         if($record['search_area']==$_POST['self_area_select'] && $record['self_number']-$record['search_number']<=$_POST['team_number_select'] && $_POST['team_number_select']<=$record['self_number']+$record['search_number'])
                         {
                              if(empty($host))
                              {
                                   $host=$record['host'];$self_number=$record['self_number'];$self_area=$record['self_area'];$self_school=$record['self_school'];
                                   $self_department=$record['self_department'];$self_grade=$record['self_grade'];$sex=$record['sex'];
                              }
                         }
                     }else{
                          if($record['search_grade']==$_POST['self_grade_select'] && $record['search_area']==$_POST['self_area_select'] && $record['self_number']-$record['search_number']<=$_POST['team_number_select'] && $_POST['team_number_select']<=$record['self_number']+$record['search_number'])
                          {
                              if(empty($host))
                              {
                                   $host=$record['host'];$self_number=$record['self_number'];$self_area=$record['self_area'];$self_school=$record['self_school'];
                                   $self_department=$record['self_department'];$self_grade=$record['self_grade'];$sex=$record['sex'];
                              }
                          }
                     }
                 }else{
                     if($record['search_grade']=='0'){
                          if($record['search_department']==$_POST['self_department_select'] && $record['search_area']==$_POST['self_area_select'] && $record['self_number']-$record['search_number']<=$_POST['team_number_select'] && $_POST['team_number_select']<=$record['self_number']+$record['search_number'])
                          {
                              if(empty($host))
                              {
                                   $host=$record['host'];$self_number=$record['self_number'];$self_area=$record['self_area'];$self_school=$record['self_school'];
                                   $self_department=$record['self_department'];$self_grade=$record['self_grade'];$sex=$record['sex'];
                              }
                          }
                     }else{
                            if($record['search_department']==$_POST['self_department_select'] && $record['search_grade']==$_POST['self_grade_select'] && $record['search_area']==$_POST['self_area_select'] && $record['self_number']-$record['search_number']<=$_POST['team_number_select'] && $_POST['team_number_select']<=$record['self_number']+$record['search_number'])
                             {
                                  if(empty($host))
                                  {
                                       $host=$record['host'];$self_number=$record['self_number'];$self_area=$record['self_area'];$self_school=$record['self_school'];
                                       $self_department=$record['self_department'];$self_grade=$record['self_grade'];$sex=$record['sex'];
                                  }
                             }
                     }
                     
                 }
             }else{
                 if($record['search_department']=='不限'){
                     if($record['search_grade']=='0'){
                          if($record['search_school']==$_POST['self_school_select'] && $record['search_area']==$_POST['self_area_select'] && $record['self_number']-$record['search_number']<=$_POST['team_number_select'] && $_POST['team_number_select']<=$record['self_number']+$record['search_number'])
                          {
                              if(empty($host))
                              {
                                   $host=$record['host'];$self_number=$record['self_number'];$self_area=$record['self_area'];$self_school=$record['self_school'];
                                   $self_department=$record['self_department'];$self_grade=$record['self_grade'];$sex=$record['sex'];
                              }
                          }
                     }else{
                           if($record['search_school']==$_POST['self_school_select'] && $record['search_grade']==$_POST['self_grade_select'] && $record['search_area']==$_POST['self_area_select'] && $record['self_number']-$record['search_number']<=$_POST['team_number_select'] && $_POST['team_number_select']<=$record['self_number']+$record['search_number'])
                          {
                              if(empty($host))
                              {
                                   $host=$record['host'];$self_number=$record['self_number'];$self_area=$record['self_area'];$self_school=$record['self_school'];
                                   $self_department=$record['self_department'];$self_grade=$record['self_grade'];$sex=$record['sex'];
                              }
                          }
                     }
                 }else{
                     if($record['search_grade']=='0'){
                          if($record['search_school']==$_POST['self_school_select'] && $record['search_department']==$_POST['self_department_select'] && $record['search_area']==$_POST['self_area_select'] && $record['self_number']-$record['search_number']<=$_POST['team_number_select'] && $_POST['team_number_select']<=$record['self_number']+$record['search_number'])
                          {
                              if(empty($host))
                              {
                                   $host=$record['host'];$self_number=$record['self_number'];$self_area=$record['self_area'];$self_school=$record['self_school'];
                                   $self_department=$record['self_department'];$self_grade=$record['self_grade'];$sex=$record['sex'];
                              }
                          }
                     }else{
                          if($record['search_school']==$_POST['self_school_select'] && $record['search_department']==$_POST['self_department_select'] && $record['search_grade']==$_POST['self_grade_select'] && $record['search_area']==$_POST['self_area_select'] && $record['self_number']-$record['search_number']<=$_POST['team_number_select'] && $_POST['team_number_select']<=$record['self_number']+$record['search_number'])
                          {
                              if(empty($host))
                              {
                                   $host=$record['host'];$self_number=$record['self_number'];$self_area=$record['self_area'];$self_school=$record['self_school'];
                                   $self_department=$record['self_department'];$self_grade=$record['self_grade'];$sex=$record['sex'];
                              }
                          }
                     }                    
                 }  
             }
         }
         //假如有配對到($host存在) 則更新隊員使用者資訊 將並將隊伍從等待配對中的名單中刪除
         if(isset($host))
         {   
             if($_SESSION['user_sex']=='1')
             {
                  $sql = "INSERT INTO matching_table (host1,number1,area1,school1,department1,grade1,host2,number2,area2,school2,department2,grade2) VALUES
                      ('".$host."','".$self_number."','".$self_area."','".$self_school."','".$self_department."','".$self_grade."',
                       '".$_SESSION['id']."', '".$_POST['team_number_select']."','".$_POST['self_area_select']."','".$_POST['self_school_select']."','".$_POST['self_department_select']."','".$_POST['self_grade_select']."')";
             }else{
                       $sql = "INSERT INTO matching_table (host1,number1,area1,school1,department1,grade1,host2,number2,area2,school2,department2,grade2) VALUES
                      ('".$_SESSION['id']."', '".$_POST['team_number_select']."','".$_POST['self_area_select']."','".$_POST['self_school_select']."','".$_POST['self_department_select']."','".$_POST['self_grade_select']."',
                      '".$host."','".$self_number."','".$self_area."','".$self_school."','".$self_department."','".$self_grade."')";
             }
              mysqli_query($con,$sql) or die(mysqli_error($con));
              $sql = "SELECT * FROM matching_table WHERE host1 IN ('".$host."','".$_SESSION['id']."')";
              $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
              $rows = mysqli_fetch_assoc($res);
              $sql = "UPDATE user_info SET match_id = '".$rows['id']."' WHERE user_host in ('".$_SESSION['id']."','".$host."')";
              mysqli_query($con,$sql) or die(mysqli_error($con));
              $sql = "UPDATE user_info SET user_state = '3' WHERE match_id = '".$rows['id']."' ";
              mysqli_query($con,$sql) or die(mysqli_error($con));
              $sql = "DELETE FROM searching_match WHERE host = '".$host."' ";
              mysqli_query($con,$sql) or die(mysqli_error($con));
              $sql = "SELECT * FROM user_info WHERE match_id ='".$rows['id']."'";
              $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
              while($record = mysqli_fetch_array($res)){
              $sql = "INSERT INTO invite_message (sendto,sender,content) VALUES ('".$record['id']."','".$_SESSION['id']."',5)";
              mysqli_query($con,$sql) or die(mysqli_error($con));
              }
              echo 1;
         }else{
              $sql = "INSERT INTO searching_match (host, sex, self_number, self_area, self_school, self_department, self_grade, find, search_area, search_school, search_department, search_grade, search_number) 
                    VALUES ('".$_SESSION['user_host']."','".$_SESSION['user_sex']."','".$_POST['team_number_select']."','".$_POST['self_area_select']."'
                        ,'".$_POST['self_school_select']."' ,'".$_POST['self_department_select']."','".$_POST['self_grade_select']."','".$_POST['match_find_select']."','".$_POST['match_area_select']."'
                        ,'".$_POST['match_school_select']."','".$_POST['match_department_select']."','".$_POST['match_grade_select']."','".$_POST['match_number_select']."')";
              mysqli_query($con,$sql) or die(mysqli_error($con));
              $sql = "UPDATE user_info SET user_state = '2' WHERE user_host = '".$_SESSION['id']."' ";
              mysqli_query($con,$sql) or die(mysqli_error($con));
               // 告知所有隊員開始等待配對
              $sql = "SELECT * FROM user_info WHERE user_host ='".$_SESSION['id']."'";
              $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
              while($record = mysqli_fetch_array($res)){
                  $sql = "INSERT INTO invite_message (sendto,sender,content) VALUES ('".$record['id']."','".$_SESSION['id']."',4)";
                  mysqli_query($con,$sql) or die(mysqli_error($con));
              }
              echo 0;
         }
         
         
?>
