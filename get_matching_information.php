<?php
        $dbhost = '127.0.0.1';
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'partnera';
        $con = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection'); 
        mysqli_query($con,"set names 'UTF8' ");
        mysqli_select_db($con,$dbname);
        session_start(); 
        //讀出配對的成員資訊
        $matching_member_woman=array();
        $matching_member_man=array();  
        $sql = "SELECT * FROM user_info WHERE match_id ='".$_SESSION['match_id']."'AND id = user_host";
        $res = mysqli_query($con,$sql) or die(mysqli_error($con));
        while($out = mysqli_fetch_array($res)){   //先讀出隊長 排在陣列第一筆
            if($out['user_sex']==0)
               $matching_member_woman[]=array($out['id'],$out['user_name']);
            if($out['user_sex']==1)
               $matching_member_man[]=array($out['id'],$out['user_name']);
         }
        $sql = "SELECT * FROM user_info WHERE match_id ='".$_SESSION['match_id']."'";
        $res = mysqli_query($con,$sql) or die(mysqli_error($con));
        while($out = mysqli_fetch_array($res)){  //其後將隊員讀出
            if($out['user_sex']==0 && $out['id'] != $out['user_host'])
                $matching_member_woman[]=array($out['id'],$out['user_name']);
            if($out['user_sex']==1 && $out['id'] != $out['user_host'])
                $matching_member_man[]=array($out['id'],$out['user_name']);
         }         
         //讀出配對資訊
         $sql = "SELECT * FROM matching_table WHERE id ='".$_SESSION['match_id']."'";
         $res = mysqli_query($con,$sql) or die(mysqli_error($con));
         $matching_info = mysqli_fetch_assoc($res) ;

         mysqli_close($con);
         session_write_close();
?>
