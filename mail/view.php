<?php

$URLcipher = new URLcipher();

$decryptedtext = $URLcipher->decrypt($_SERVER['QUERY_STRING']);

if ( trim($_GET['ms']) != '' && trim($_GET['mb']) != '' ) {
  echo '<body style="margin:0px;background-color:#F5F5F5;"><div style="width:100%;padding:5px 0 5px 0;">';
  echo '<div style="width:600px;background-color:#FFFFFF;margin: 0px auto 0px auto;">';

  // get the message
  $query  = "SELECT body
               FROM " . $phpml['dbMsgs'] . "
              WHERE msgid    = " . $_GET['ms'];
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error() . '<br />' . $query);
  $row = mysql_fetch_assoc($result);
  $msgBody = $row['body'];
  // get the recipient
  $query  = "SELECT *
               FROM " . $phpml['dbMembers'] . "
              WHERE memberid = " . $_GET['mb'];
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error() . '<br />' . $query);

  $row = mysql_fetch_assoc($result);
  $fullName = '';
  if ( $row['firstname'] ) {
    $fullName .= " " . $row['firstname'];
  }
  if ( $row['lastname'] ) {
    $fullName .= " " . $row['lastname'];
  }
  $fullName = trim($fullName);
  $mailingListTitle = '';
  $getMb     = $_GET['mb'];
  $getMs     = $_GET['ms'];
  $viewLink  = $phpml['url_root'] . '/index.php?' . $URLcipher->encrypt('mb=' . $getMb . '&ms=' . $getMs);
  $substiarr = array("{msgid}" => $getMs, "%%msgid%%" => $getMs, "%7Bmsgid%7D" => $getMs, "{onlineviewurl}" => $viewLink, "%%onlineviewurl%%" => $viewLink, "%7Bonlineviewurl%7D" => $viewLink, "{mailinglist}" => $mailingListTitle, "%%mailinglist%%" => $mailingListTitle, "%7Bmailinglist%7D" => $mailingListTitle, "{applicationname}" => $phpml['ListName'], "%%applicationname%%" => $phpml['ListName'], "%7Bapplicationname%7D" => $phpml['ListName'], "{unsubscribe}" => $unsubscribeLink, "%%unsubscribe%%" => $unsubscribeLink, "%7Bunsubscribe%7D" => $unsubscribeLink, "{firstname}" => $row['firstname'], "%%firstname%%" => $row['firstname'], "%7Bfirstname%7D" => $row['firstname'], "{lastname}" => $row['lastname'], "%%lastname%%" => $row['lastname'], "%7Blastname%7D" => $row['lastname'], "{ip}" => $row['ip'], "%%ip%%" => $row['ip'], "%7Bip%7D" => $row['ip'], "{remote_host}" => $row['RH'], "%%remote_host%%" => $row['RH'], "%7Bremote_host%7D" => $row['RH'], "{reg_date}" => date("F j, Y, g:i a", $row['regdate']), "%%reg_date%%" => date("F j, Y, g:i a", $row['regdate']), "%7Breg_date%7D" => date("F j, Y, g:i a", $row['regdate']), "{email}" => $row['email'], "%%email%%" => $row['email'], "%7Bemail%7D" => $row['email']);
  $msgBody   = strtr($msgBody, $substiarr);

  if ($phpml['trackOpens']) {
    $trackLink       = '<img border="0" src="' . $phpml['url_root'] . '/getimg.php?';
    $trackLink      .= 'eid="' . $_GET['mb'] . '&';
    $trackLink      .= 'mid="' . $_GET['ms'] . '" width="2" height="2">';
    $msgBody         = str_replace('<!--imgtrack-->',$trackLink,$msgBody);
  }

  echo stripslashes($msgBody);
  echo '</div>';
  echo '</div></body>';
} else {
  exit();
}

?>