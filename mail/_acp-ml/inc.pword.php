<?php

defined('_WRX') or die( _errorMsg('Restricted access') );

echo '<div align="center">';

// if your .htpasswd filename never changes then fill in variable below
$filepass = '.htpasswd';

if(is_file($filepass)) {
  $htpassfile = file($filepass);
  $sizeoffile = count($htpassfile);
}

if($_POST['Submit'] == "Submit!") {
  $dsize = count($user);
  for($y=0; $y<$dsize; $y++) {
    if($user[$y]) {
      for($i=0; $i<$sizeoffile; $i++) {
        $myuser = explode(":", $htpassfile[$i]);
        if($user[$y] == $myuser[0]) {
          $htpassfile[$i] = "";
          $matched++;
        }
      }
    }
  }
  $names = $_POST["name"];
  $passs = $_POST["pass"];
  $deles = $_POST["dele"];
  $cntnames = count($names);

  if($filehandle = fopen("$filepass", "w")) {
    $report = "rep = '';";
    for($i=0; $i < $cntnames; $i++) {
      if ($names[$i] != "") {
        if ($deles[$i] != "ON") {
          $orgpassarr = split (":", $htpassfile[$i]);
          $orgpass    = trim($orgpassarr[1]);
          if($passs[$i] != $orgpass) {
            $report .= "rep += 'Changed: $names[$i]\\n';";
            fputs($filehandle, $names[$i] . ":" . crypt(trim($passs[$i]),base64_encode(CRYPT_STD_DES)) . "\r\n");
          } else {
            $report .= "rep += 'Not changed: $names[$i]\\n';";
            fputs($filehandle, $names[$i] . ":" . $orgpass . "\r\n");
          }
        } else {
          $report .= "rep += 'Deleted: $names[$i]\\n';";
        }
      } else {
        echo "deleted: $names[$i] / $deles[$i]<br>";
      }
    }
    fclose($filehandle);
  }
  echo "<script language=javascript>" . $report . "alert(rep);</script>";
  echo "<script language=\"Javascript\">window.location.href='index.php?pg=pword';</script>";
  exit;
} else {
  echo "<form method=\"POST\" action=\"index.php?pg=pword\">\n";
  // Get the title (AuthName) from .htaccess
  for($i=0; $i<$sizeofacc ; $i++) {
    $testline = $htpassacc[$i];
    if (substr($testline, 0, 8) == "AuthName") {
      $dirtext = substr($testline, 10, -3);// AuthName "Password Protected Area"
    }
  }
  // now sort and display the .htpasswd file
  echo "<div align=\"center\">\n<br><table border=\"0\" width=\"450\" cellspacing=\"0\" cellpadding=\"5\" id=\"table1\">\n";
  echo "<tr>\n<td class=\"frmcnt\">Name</td>\n";
  echo "<td class=\"frmcnt\" >Password</td>\n";
  echo "<td class=\"frmcnt\" >Delete?</td>\n</tr>\n";
  for($i=0; $i<$sizeoffile ; $i++) {
    $myuser = explode(':', $htpassfile[$i]);
    if($myuser[0] != "\n" && $myuser[0] != "" && $myuser[0] != " ") {
      echo "<tr>\n<td><input class=\"textbox\"  type=\"text\" name=\"name[$i]\" size=\"20\" value=\"" . trim($myuser[0]) . "\"></td>\n";
      echo "<td><input class=\"textbox\"  type=\"password\" name=\"pass[$i]\" size=\"20\" value=\"" . trim($myuser[1]) . "\"></td>\n";
      echo "<td><input type=\"checkbox\" name=\"dele[$i]\" value=\"ON\" id=\"dele[$i]\"></td>\n</tr>\n";
      $count++;
    }
  }
  echo "<tr>\n<td><input class=\"textbox\"  type=\"text\" name=\"name[" . ($i) . "]\" size=\"20\" value=\"\"></td>\n";
  echo "<td><input class=\"textbox\" type=\"password\" name=\"pass[" . ($i) . "]\" size=\"20\" value=\"\"></td>\n";
  echo "<td class=\"datatext\">(new)</td>\n</tr>\n";
  echo "</table>\n</div>";
  echo "<p><center><input type=\"submit\" class=\"button\" name=\"Submit\" value=\"Submit!\"></center></form>";
}

echo '</div>';

$pgArr['caption'] = $PHPML_LANG["usermgt"];
$pgArr['contents'] = ob_get_contents();
$pgArr['help']     = "Manage your users.
  Number of hidden characters in password field may not match the count of characters in actual password.";
ob_end_clean();
echo getSkin ($pgArr);

?>
