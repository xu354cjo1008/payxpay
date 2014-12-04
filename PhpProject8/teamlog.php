<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
        <body>
           你的隊伍有 <?php echo $_POST['number']; ?>人<br />
           你們來自於 <?php echo $_POST['area']; ?><br />
           就讀於 <?php echo $_POST['school']; ?>  
           的 <?php echo $_POST['department']; ?> 系所<br />
           <?php
              require('logdata.php');
              $tbname = 'jointeam';
              $con = mysqli_connect($dbhost, $dbuser, $dbpass);
              if (!$con)
              {
                  die("Connection error: " . mysqli_connect_errno());
              }
              mysqli_query($con,"SET NAMES 'utf8'");
              mysqli_select_db($con,$dbname);
              $area=  mysqli_real_escape_string($con,$_POST['area']);
              $school=mysqli_real_escape_string($con,$_POST['school']);
              $department=  mysqli_real_escape_string($con,$_POST['department']);
              $number=  mysqli_real_escape_string($con,$_POST['number']);
             // $sql = "INSERT INTO $tbname (area, school, department, number) VALUES ('Taipei','NTU','EE','5')";
              $sql = "INSERT INTO $tbname (area, school, department, number) VALUES ('$area','$school','$department','$number')";
              if (!mysqli_query($con,$sql))
              {
                  die('Error: ' . mysqli_error($con));
              }
              echo "1 record added";
              mysqli_close($con);
//
//              while($row = mysql_fetch_array($result)){
//                  echo $row['name'];
//              }
              header("Location:mate.php" )
          ?>
       </body>
</html>