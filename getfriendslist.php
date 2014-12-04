<?php
      //讀取好友名單     friendslist  | id | user_id | friend_id |
        $dbhost = '127.0.0.1';
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'partnera';
        $con = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection'); 
        mysqli_query($con,"set names 'UTF8' ");
        mysqli_select_db($con,$dbname);
        session_start(); 
        //取出已邀請的名單 並放入$friends_invited[]中
        $sql = "SELECT * FROM invite_message WHERE sender ='".$_SESSION['id']."' AND content = 0 ";
        $res = mysqli_query($con,$sql) or die(mysqli_error($con));
        $friends_invited=array();
        while($out = mysqli_fetch_array($res)){
            $friends_invited[]=$out['sendto'];
         }
        $sql = "SELECT * FROM user_info WHERE user_state <> 0";
        $res = mysqli_query($con,$sql) or die(mysqli_error($con));
        while($out = mysqli_fetch_array($res)){
            $friends_invited[]=$out['id'];
         }       
        $sql = "SELECT * FROM friendslist WHERE user_id ='".$_SESSION['id']."' OR friend_id='".$_SESSION['id']."'";
        session_write_close();
        $res = mysqli_query($con,$sql) or die(mysqli_error($con));
        while($record = mysqli_fetch_array($res)){
            $flag=0;
            foreach ($friends_invited as $value) {      //判斷是否已邀請
                if($record['friend_id']==$value)
                    $flag=1;
            }
            if($flag == 0)
               $friends_id[]=$record['friend_id'];
         }
         $friends_list=  array();
         for($i=0;$i<count($friends_id);$i++)
         {
             $sql = "SELECT * FROM user_info WHERE id ='".$friends_id[$i]."'";
             $res = mysqli_query($con,$sql) or die(mysqli_error($con));
             $record = mysqli_fetch_assoc($res);
             $friends_list[]=array($record['id'],$record['user_name']);
         }       
         mysqli_close($con);
         echo json_encode($friends_list);
?>
