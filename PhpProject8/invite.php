
<?php        
            include_once("logdata.php");
            $con = mysqli_connect($dbhost, $dbuser, $dbpass);
            mysqli_select_db($con,$dbname);
            $invite=  mysqli_real_escape_string($con,$_POST['invite']);
             session_start(); 
            $sql = "INSERT INTO mailbox (fid,sender,content) VALUES ('".$invite."','".$_SESSION['username']."','invite')";
            mysqli_query($con,$sql) or die(mysqli_error($con));
            mysqli_close($con);
            header("location:room.php"); 
          
?>
