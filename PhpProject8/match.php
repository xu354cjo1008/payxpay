<?php

include_once("logdata.php");
$con = mysqli_connect($dbhost, $dbuser, $dbpass);
 mysqli_select_db($con,$dbname);
 mysqli_query($con,"SET NAMES 'utf8'");
 session_start();
 if($_SESSION['sex']=='male')
     $searchsex='female';
 else
     $searchsex='male';
 //$_POST['number'];
 if($_POST['searcharea']=='不限')
 {
     if($_POST['searchdepartment']=='不限')
     {
         if($_POST['searchgrade']==0)
         {
                  $sql = "SELECT * FROM team WHERE sex ='".$searchsex."'AND find='".$_POST['find']."'";
                 $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
               //  echo "33333";
         }
         else
         {
                  $sql = "SELECT * FROM team WHERE sex ='".$searchsex."'
                       AND grade='".$_POST['searchgrade']."'
                           AND find='".$_POST['find']."'";
                 $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
         }
     }else
         if($_POST['searchgrade']==0)
         {
                 $sql = "SELECT * FROM team WHERE sex ='".$searchsex."'
                   AND department='".$_POST['searchdepartment']."'
                       AND find='".$_POST['find']."' ";
                 $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
         }
         else
         {
                  $sql = "SELECT * FROM team WHERE sex ='".$searchsex."'
                   AND department='".$_POST['searchdepartment']."' AND grade='".$_POST['searchgrade']."'
                       AND find='".$_POST['find']."'";
                 $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
         }
 }else{
     if($_POST['searchschool']=='不限')
     {
          if($_POST['searchdepartment']=='不限')
         {
             if($_POST['searchgrade']==0)
             {
                  $sql = "SELECT * FROM team WHERE sex ='".$searchsex."'
                  AND area='".$_POST['searcharea']."'AND find='".$_POST['find']."'";
                  $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
             }
             else
             {
                 $sql = "SELECT * FROM team WHERE sex ='".$searchsex."'
                 AND area='".$_POST['searcharea']."' AND grade='".$_POST['searchgrade']."'
                     AND find='".$_POST['find']."'";
                 $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
             }
         }else{
             if($_POST['searchgrade']==0)
             {
                  $sql = "SELECT * FROM team WHERE sex ='".$searchsex."' AND area='".$_POST['searcharea']."'
                   AND department='".$_POST['searchdepartment']."'AND find='".$_POST['find']."'";
                 $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
             }
             else
             {
                  $sql = "SELECT * FROM team WHERE sex ='".$searchsex."'
                 AND area='".$_POST['searcharea']."'AND department='".$_POST['searchdepartment']."' 
                     AND grade='".$_POST['searchgrade']."'AND find='".$_POST['find']."'";
                 $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
             }  
         }
     }else{
         if($_POST['searchdepartment']=='不限')
         {
             if($_POST['searchgrade']==0)
             {
                  $sql = "SELECT * FROM team WHERE sex ='".$searchsex."'
                 AND area='".$_POST['searcharea']."' AND school='".$_POST['searchschool']."'
                     AND find='".$_POST['find']."'";
                 $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
             }
             else
             {
                 $sql = "SELECT * FROM team WHERE sex ='".$searchsex."'
                 AND area='".$_POST['searcharea']."' AND school='".$_POST['searchschool']."' 
                    AND grade='".$_POST['searchgrade']."'AND find='".$_POST['find']."'";
                 $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
             }
         }else{
             if($_POST['searchgrade']==0)
             {
                  $sql = "SELECT * FROM team WHERE sex ='".$searchsex."'
                 AND area='".$_POST['searcharea']."' AND school='".$_POST['searchschool']."' 
                   AND department='".$_POST['searchdepartment']."'AND find='".$_POST['find']."'";
                 $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
             }
             else
             {
                  $sql = "SELECT * FROM team WHERE sex ='".$searchsex."'
                 AND area='".$_POST['searcharea']."' AND school='".$_POST['searchschool']."' 
                   AND department='".$_POST['searchdepartment']."' AND grade='".$_POST['searchgrade']."'
                     AND find='".$_POST['find']."'";
                 $res=  mysqli_query($con,$sql) or die(mysqli_error($con)); 
             }  
         }
     }
  }
     
$pid=0;
//$rows = mysqli_fetch_assoc($res);
while($record = mysqli_fetch_array($res)){
    if($record['searcharea']=='不限')
     {
         if($record['searchdepartment']=='不限')
         {
             if($record['searchgrade']==0)
             {
                     // if($record['id']<$pid) 
                        //  $pid=$record['id'];
                      if(empty($host))
                         $host=$record['host'];
                       //  echo "aaaa";
             }
             else
             {
                 if($record['searchgrade']==$_POST['grade'])
                 {
                      if(empty($host))
                         $host=$record['host'];
                 }
             }
         }else
             if($record['searchgrade']==0)
             {
                 if($record['searchdepartment']==$_POST['department'])
                 {
                      if(empty($host))
                         $host=$record['host'];
                 }
             }
             else
             {
                 if($record['searchdepartment']==$_POST['department'] && $record['searchgrade']==$_POST['grade'])
                 {
                      if(empty($host))
                         $host=$record['host'];
                 }
             }
     }else{
         if($record['searchschool']=='不限')
         {
              if($record['searchdepartment']=='不限')
             {
                 if($record['searchgrade']==0)
                 {
                      if($record['searcharea']==$_POST['area'])
                      {
                        if(empty($host))
                           $host=$record['host'];
                      }
                 }
                 else
                 {
                      if($record['searcharea']==$_POST['area'] && $record['searchgrade']==$_POST['grade'])
                      {
                        if(empty($host))
                           $host=$record['host'];
                      }
                 }
             }else{
                 if($record['searchgrade']==0)
                 {
                      if($record['searcharea']==$_POST['area'] && $record['searchdepartment']==$_POST['department'])
                      {
                        if(empty($host))
                           $host=$record['host'];
                      }
                 }
                 else
                 {
                      if($record['searcharea']==$_POST['area'] && $record['searchdepartment']==$_POST['department'] 
                              && $record['searchgrade']==$_POST['grade'])
                      {
                         if(empty($host))
                            $host=$record['host'];
                      }
                 }  
             }
         }else{
             if($record['searchdepartment']=='不限')
             {
                 if($record['searchgrade']==0)
                 {
                      if($record['searcharea']==$_POST['area'] && $record['searchschool']==$_POST['school'])
                      {
                          if(empty($host))
                             $host=$record['host'];
                      }
                 }
                 else
                 {
                      if($record['searcharea']==$_POST['area'] && $record['searchschool']==$_POST['school']
                              && $record['searchgrade']==$_POST['grade'])
                      {
                          if(empty($host))
                             $host=$record['host'];
                      } 
                 }
             }else{
                 if($record['searchgrade']==0)
                 {
                      if($record['searcharea']==$_POST['area'] && $record['searchschool']==$_POST['school']
                              && $record['searchdepartment']==$_POST['department'])
                      {
                          if(empty($host))
                             $host=$record['host'];
                      } 
                 }
                 else
                 {
                      if($record['searcharea']==$_POST['area'] && $record['searchschool']==$_POST['school']
                             && $record['searchdepartment']==$_POST['department'] && $record['searchgrade']==$_POST['grade'])
                      {
                          if(empty($host))
                             $host=$record['host'];
                      } 
                 }  
             }
         }
      }   
     // $arr=
}
if(isset($host))
{      
      $sql = "DELETE FROM team WHERE host = '".$host."' ";
      $res = mysqli_query($con,$sql) or die(mysql_error());
      $sql = "UPDATE user SET roomhost = '".$host."' WHERE roomhost = '".$_SESSION['id']."' ";
      $res = mysqli_query($con,$sql) or die(mysql_error());
      $sql = "UPDATE user SET state = '3' WHERE roomhost = '".$host."' ";
      $res = mysqli_query($con,$sql) or die(mysql_error());

}else{
    $sql = "INSERT INTO team (host, sex, number, area, school, department, grade, find, searcharea, searchschool, searchdepartment, searchgrade, searchnumber) 
        VALUES ('".$_SESSION['roomhost']."','".$_SESSION['sex']."','".$_POST['number']."','".$_POST['area']."','".$_POST['school']."'
            ,'".$_POST['department']."','".$_POST['grade']."','".$_POST['find']."','".$_POST['searcharea']."'
                ,'".$_POST['searchschool']."','".$_POST['searchdepartment']."','".$_POST['searchgrade']."','".$_POST['searchnumber']."')";
             mysqli_query($con,$sql) or die(mysqli_error($con));
      $sql = "UPDATE user SET state = '2' WHERE roomhost = '".$_SESSION['id']."' ";
      $res = mysqli_query($con,$sql) or die(mysql_error());
}
//echo $arr;
header("location:room.php"); 
?>
