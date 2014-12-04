<?php
/*~ _acp-ml/inc.campaigns.php
.---------------------------------------------------------------------------.
|  Software: PHPMailer-ML - PHP mailing list                                |
|   Version: 1.8                                                            |
|   Contact: via sourceforge.net support pages (also www.codeworxtech.com)  |
|      Info: http://phpmailer.sourceforge.net                               |
|   Support: http://sourceforge.net/projects/phpmailer/                     |
| ------------------------------------------------------------------------- |
|    Author: Andy Prevost (project admininistrator)                         |
| Copyright (c) 2004-2009, Andy Prevost. All Rights Reserved.               |
| ------------------------------------------------------------------------- |
|   License: Distributed under the General Public License (GPL)             |
|            (http://www.gnu.org/licenses/gpl.html)                         |
| This program is distributed in the hope that it will be useful - WITHOUT  |
| ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     |
| FITNESS FOR A PARTICULAR PURPOSE.                                         |
| ------------------------------------------------------------------------- |
| We offer a number of paid services (www.codeworxtech.com):                |
| - Web Hosting on highly optimized fast and secure servers                 |
| - Technology Consulting                                                   |
| - Oursourcing (highly qualified programmers and graphic designers)        |
'---------------------------------------------------------------------------'

/**
 * PHPMailer-ML - PHP mailing list manager
 * @package PHPMailer-ML
 * @author Andy Prevost
 * @copyright 2004 - 2009 Andy Prevost. All Rights Reserved.
 */

defined('_WRX') or die( _errorMsg('Restricted access') );

echo '<div align="center">';
echo '<br />';

if ($_POST['frmWhichList']) {
  $def_list = $_POST['frmWhichList'];
  $_SESSION['def_list'] = $def_list;
}

if ($_GET['proc'] == 'del') {
  foreach ($_POST['frmDelete'] as $key => $value) {
    $query = "DELETE FROM " . $phpml['dbMsgs'] . "
                WHERE msgid = $key";
    $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
    echo $PHPML_LANG["campaign"] . " ID " . $key  . " " .$PHPML_LANG["deleted"] . "<br>";
  }
  echo '<meta http-equiv="refresh" content="3;url=index.php?pg=campaigns" />';
} elseif ($_GET['proc'] == 'send') {
  // get message
  $query  = "SELECT *
               FROM " . $phpml['dbMsgs'] . "
              WHERE msgid = " . $_GET['id'];
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  $row = mysql_fetch_assoc($result);
  $message_org = stripslashes(stripslashes($row['body']));
  $subject_org = stripslashes(stripslashes($row['subject']));
  $format_org  = stripslashes(stripslashes($row['format']));
  // get list information
  $query  = "SELECT *
               FROM " . $phpml['dbLists'] . "
              WHERE listid    = " . $_SESSION['def_list'];
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  $row = mysql_fetch_assoc($result);
  $phpml['FromName'] = $row['listowner'];
  $phpml['FromAddy'] = $row['listemail'];
  _load_PHPMailer();
  $mail = new MyMailer;
  $query  = "SELECT *
               FROM " . $phpml['dbMembers'] . "
              WHERE listid = '" . $_SESSION['def_list'] . "'
                AND confirmed = '1'
                AND deleted   = '0'";
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  $num    = mysql_num_rows($result);

  $x_ok                = 0;     // current count of sent in emails processed
  $x_errors            = 0;     // current count of errors in emails processed
  $xi                  = 0;     // current count of emails processed
  $width               = 0;     //  the starting width of the progress bar
  $percentage          = 0;     //  the starting percentage (should always be zero)
  $total_iterations    = $num;  //  the number of emails to sent (total)
  $width_per_iteration = 300 / $total_iterations; // how many pixels should the progress div be increased per each iteration, based on width of progress bar div
  ?>
  <style>
  .progress_wrapper {
    width:300px;
    border:1px solid #000;
    position:absolute;
    top:20px;
    left:20px;
    height:20px;
  }
  .progress {
    height:20px;
    background: #fff url('appimgs/progress.gif');
    color:#000;
    text-align:center;
    font: 11px/20px Arial, Helvetica, sans-serif;
  }
  </style>
  <?php
  ob_start();
  while ( $row = mysql_fetch_assoc($result) ) {
    $fullName = '';
    if ( $row['firstname'] ) {
      $fullName .= " " . $row['firstname'];
    }
    if ( $row['lastname'] ) {
      $fullName .= " " . $row['lastname'];
    }
    $fullName = trim($fullName);
    if ($phpml['useBcc']) {
      $mail->AddBcc($row['email']);
    } else {
      if ( $fullName ) {
        $mail->AddAddress($row['email'], $fullName);
      } else {
        $mail->AddAddress($row['email']);
      }
    }
    // get mailing list name
    $queryl  = "SELECT *
                  FROM " . $phpml['dbLists'] . "
                 WHERE listid    = " . $_SESSION['def_list'];
    $resultl = mysql_query($queryl) or die($PHPML_LANG["error_query"] . mysql_error());
    $rowl = mysql_fetch_assoc($resultl);
    $mailingListTitle = $rowl['title'];
    // build and personalize the message and subject
    $unsubscribeLink = $phpml['url_root'] . '/index.php?pg=d&action=unsubscribe&mid=' . $row['memberid'] . '&nid=' . md5($row['email']);
    $URLcipher     = new URLcipher();
    $getMb         = $row['memberid'];
    $getMs         = $_GET['id'];
    $viewLink      = $phpml['url_root'] . '/index.php?' . $URLcipher->encrypt('mb=' . $getMb . '&ms=' . $getMs);
    $viewmsgid     = $_GET['id'];
    $substiarr     = array("{msgid}" => $getMs, "%%msgid%%" => $getMs, "%7Bmsgid%7D" => $getMs, "{onlineviewurl}" => $viewLink, "%%onlineviewurl%%" => $viewLink, "%7Bonlineviewurl%7D" => $viewLink, "{mailinglist}" => $mailingListTitle, "%%mailinglist%%" => $mailingListTitle, "%7Bmailinglist%7D" => $mailingListTitle, "{applicationname}" => $phpml['ListName'], "%%applicationname%%" => $phpml['ListName'], "%7Bapplicationname%7D" => $phpml['ListName'], "{unsubscribe}" => $unsubscribeLink, "%%unsubscribe%%" => $unsubscribeLink, "%7Bunsubscribe%7D" => $unsubscribeLink, "{firstname}" => $row['firstname'], "%%firstname%%" => $row['firstname'], "%7Bfirstname%7D" => $row['firstname'], "{lastname}" => $row['lastname'], "%%lastname%%" => $row['lastname'], "%7Blastname%7D" => $row['lastname'], "{ip}" => $row['ip'], "%%ip%%" => $row['ip'], "%7Bip%7D" => $row['ip'], "{remote_host}" => $row['RH'], "%%remote_host%%" => $row['RH'], "%7Bremote_host%7D" => $row['RH'], "{reg_date}" => date("F j, Y, g:i a", $row['regdate']), "%%reg_date%%" => date("F j, Y, g:i a", $row['regdate']), "%7Breg_date%7D" => date("F j, Y, g:i a", $row['regdate']), "{email}" => $row['email'], "%%email%%" => $row['email'], "%7Bemail%7D" => $row['email']);
    $mail->Subject = strtr($subject_org, $substiarr);
    $message       = stripslashes($message_org);
    $message       = strtr($message, $substiarr);
    $searchStr = '"/' . $phpml['path_base'] . '/_msgimgs';
    $replacStr = '"' . $phpml['path_root'] . '/_msgimgs';
    $message   = str_replace($searchStr,$replacStr,$message);
    if ($phpml['trackOpens']) {
      $trackLink       = '<img border="0" src="' . $phpml['url_root'] . '/getimg.php?';
      $trackLink      .= 'eid=' . $row['memberid'] . '&';
      $trackLink      .= 'mid=' . $_GET['id'] . '" width="2" height="2">';
      $message         = str_replace('<!--imgtrack-->',$trackLink,$message);
    }
    $h2t     =& new html2text($message);
    $textmsg = $h2t->get_text();
    if ($format_org == 'textonly') {
      $mail->Body      = $textmsg;
    } else {
      $mail->MsgHTML($message);
      $mail->AltBody    = $textmsg;
    }
    // now send it
    if(!$mail->Send()) {
      $x_errors++;
      echo $PHPML_LANG["error_sending"] . " to:" . $row['email'] . "<br /><br /><b>" . $mail->ErrorInfo . "<br /><br /></b>";
    } else {
      echo "Sent to:" . str_replace('@','&#64;',$row['email']) . "<br />";
      $x_ok++;
    }
    if ($num > 1) {
      $mail->ClearAddresses();
      $mail->ClearCCs();
      $mail->ClearBCCs();
      $mail->ClearReplyTos();
      $mail->ClearAllRecipients();
      $mail->ClearAttachments();
      $mail->ClearCustomHeaders();
    }
    $xi++;
    if ( isset($phpml['progressmin']) ) {
      $minProgressDisplay = $phpml['progressmin'];
    } else {
      $minProgressDisplay = 25;
    }
    if ($num > $minProgressDisplay) {
      $width += $width_per_iteration;
      // update progress bar
      $thisPercentage = ($width/300)*100;
      echo '<div class="progress_wrapper">';
      echo '<div class="progress" style="width:' . $width . 'px;">' .
        sprintf("%01.0f", $thisPercentage) .
        '%</div>';
      echo '</div>';
      ob_flush();
      flush();
      // END - update progress bar
    }
  }
  sleep(1);
  if ($format_org == 'textonly') {
    $tformat = 'T';
  } else {
    $tformat = 'H';
  }
  if ($phpml['trackOpens']) {
    $message = $message_org . '<!--imgtrack-->';
  } else {
    $message = $message_org;
  }
  $message = str_replace('&gt;','>',$message);
  $message = str_replace('&lt;','<',$message);
  $query = "UPDATE " . $phpml['dbMsgs'] . "
               SET subject = '" . addslashes($subject_org) . "',
                   body    = '" . addslashes($message) . "',
                   format  = '" . $tformat . "',
                   sent    = '" . time() . "',
                   numsent = '" . $x_ok . "',
                   listid  = '" . $_SESSION['def_list'] . "'
             WHERE msgid   = " . $_GET['id'];
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  echo $PHPML_LANG["sent"] . " (" . $x_ok . ") ... <br />";
  echo "<a href=\"index.php?pg=campaigns\">" . $PHPML_LANG["click_continue"] . "</a><br />";
} elseif ($_GET['send'] || $_GET['proc'] == 'send' || $_POST['sendemail'] || $_POST['savenosend']) {
  if ($_GET['send'] || $_POST['sendemail']) {
    $query  = "SELECT *
                 FROM " . $phpml['dbLists'] . "
                WHERE listid    = " . $_SESSION['def_list'];
    $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
    $row = mysql_fetch_assoc($result);
    $phpml['FromName'] = $row['listowner'];
    $phpml['FromAddy'] = $row['listemail'];
    _load_PHPMailer();
    $mail = new MyMailer;
    $message_org   = stripslashes(stripslashes($_POST['frmEditor'])) . "</div>";
    $query  = "SELECT *
                 FROM " . $phpml['dbMembers'] . "
                WHERE listid = '" . $_SESSION['def_list'] . "'
                  AND confirmed = '1'
                  AND deleted   = '0'";
    $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
    $num    = mysql_num_rows($result);

    $x_ok                = 0;     // current count of sent in emails processed
    $x_errors            = 0;     // current count of errors in emails processed
    $xi                  = 0;     // current count of emails processed
    $width               = 0;     //  the starting width of the progress bar
    $percentage          = 0;     //  the starting percentage (should always be zero)
    $total_iterations    = $num;  //  the number of emails to sent (total)
    $width_per_iteration = 300 / $total_iterations; // how many pixels should the progress div be increased per each iteration, based on width of progress bar div
    ?>
    <style>
    .progress_wrapper {
      width:300px;
      border:1px solid #000;
      position:absolute;
      top:20px;
      left:20px;
      height:20px;
    }
    .progress {
      height:20px;
      background: #fff url('appimgs/progress.gif');
      color:#000;
      text-align:center;
      font: 11px/20px Arial, Helvetica, sans-serif;
    }
    </style>
    <?php
    ob_start();

    while ( $row = mysql_fetch_assoc($result) ) {
      $fullName = '';
      if ( $row['firstname'] ) {
        $fullName .= " " . $row['firstname'];
      }
      if ( $row['lastname'] ) {
        $fullName .= " " . $row['lastname'];
      }
      $fullName = trim($fullName);
      if ($phpml['useBcc']) {
        $mail->AddBcc($row['email']);
      } else {
        if ( $fullName ) {
          $mail->AddAddress($row['email'], $fullName);
        } else {
          $mail->AddAddress($row['email']);
        }
      }
      // get mailing list name
      $queryl  = "SELECT *
                    FROM " . $phpml['dbLists'] . "
                   WHERE listid    = " . $_SESSION['def_list'];
      $resultl = mysql_query($queryl) or die($PHPML_LANG["error_query"] . mysql_error());
      $rowl = mysql_fetch_assoc($resultl);
      $mailingListTitle = $rowl['title'];
      // build and personalize the message and subject
      $unsubscribeLink = $phpml['url_root'] . '/index.php?pg=d&action=unsubscribe&mid=' . $row['memberid'] . '&nid=' . md5($row['email']);
      $URLcipher     = new URLcipher();
      $getMb         = $row['memberid'];
      $getMs         = $_POST['frmMsgId'];
      $viewLink      = $phpml['url_root'] . '/index.php?' . $URLcipher->encrypt('mb=' . $getMb . '&ms=' . $getMs);
      $substiarr     = array("{msgid}" => $getMs, "%%msgid%%" => $getMs, "%7Bmsgid%7D" => $getMs, "{onlineviewurl}" => $viewLink, "%%onlineviewurl%%" => $viewLink, "%7Bonlineviewurl%7D" => $viewLink, "{mailinglist}" => $mailingListTitle, "%%mailinglist%%" => $mailingListTitle, "%7Bmailinglist%7D" => $mailingListTitle, "{applicationname}" => $phpml['ListName'], "%%applicationname%%" => $phpml['ListName'], "%7Bapplicationname%7D" => $phpml['ListName'], "{unsubscribe}" => $unsubscribeLink, "%%unsubscribe%%" => $unsubscribeLink, "%7Bunsubscribe%7D" => $unsubscribeLink, "{firstname}" => $row['firstname'], "%%firstname%%" => $row['firstname'], "%7Bfirstname%7D" => $row['firstname'], "{lastname}" => $row['lastname'], "%%lastname%%" => $row['lastname'], "%7Blastname%7D" => $row['lastname'], "{ip}" => $row['ip'], "%%ip%%" => $row['ip'], "%7Bip%7D" => $row['ip'], "{remote_host}" => $row['RH'], "%%remote_host%%" => $row['RH'], "%7Bremote_host%7D" => $row['RH'], "{reg_date}" => date("F j, Y, g:i a", $row['regdate']), "%%reg_date%%" => date("F j, Y, g:i a", $row['regdate']), "%7Breg_date%7D" => date("F j, Y, g:i a", $row['regdate']), "{email}" => $row['email'], "%%email%%" => $row['email'], "%7Bemail%7D" => $row['email']);
      $mail->Subject = strtr($_POST['emailtitle'], $substiarr);
      $message       = stripslashes($message_org);
      $message       = strtr($message, $substiarr);
      $searchStr = '"/' . $phpml['path_base'] . '/_msgimgs';
      $replacStr = '"' . $phpml['path_root'] . '/_msgimgs';
      $message   = str_replace($searchStr,$replacStr,$message);
      if ($phpml['trackOpens']) {
        $trackLink       = '<img border="0" src="' . $phpml['url_root'] . '/getimg.php?';
        $trackLink      .= 'eid=' . $row['memberid'] . '&';
        $trackLink      .= 'mid=' . $_GET['id'] . '" width="2" height="2">';
        $message         = str_replace('<!--imgtrack-->',$trackLink,$message);
      }

      $h2t     =& new html2text($message);
      $textmsg = $h2t->get_text();

      if ($_POST['frmFormat'] == 'textonly') {
        $mail->Body      = $textmsg;
      } else {
        $mail->MsgHTML($message);
        $mail->AltBody    = $textmsg; //"To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
      }

      // now send it
      if(!$mail->Send()) {
        $x_errors++;
        echo $PHPML_LANG["error_sending"] . " to:" . $row['email'] . "<br /><br /><b>" . $mail->ErrorInfo . "<br /><br /></b>";
      } else {
        echo "sent to:" . $row['email'] . "<br />";
        $x_ok++;
      }
      if ($num > 1) {
        $mail->ClearAddresses();
        $mail->ClearCCs();
        $mail->ClearBCCs();
        $mail->ClearReplyTos();
        $mail->ClearAllRecipients();
        $mail->ClearAttachments();
        $mail->ClearCustomHeaders();
      }
      $xi++;
      if ( isset($phpml['progressmin']) ) {
        $minProgressDisplay = $phpml['progressmin'];
      } else {
        $minProgressDisplay = 25;
      }
      if ($num > $minProgressDisplay) {
        $width += $width_per_iteration;
        // update progress bar
        $thisPercentage = ($width/300)*100;
        echo '<div class="progress_wrapper">';
        echo '<div class="progress" style="width:' . $width . 'px;">' .
          sprintf("%01.0f", $thisPercentage) .
          '%</div>';
        echo '</div>';
        ob_flush();
        flush();
        // END - update progress bar
      }
    }
    sleep(1);
  }
  if ($_POST['frmFormat'] == 'textonly') {
    $tformat = 'T';
  } else {
    $tformat = 'H';
  }
  if ($_POST['frmMsgId'] != '') {
    if ($phpml['trackOpens']) {
      $message = $_POST['frmEditor'] . '<!--imgtrack-->';
    } else {
      $message = $_POST['frmEditor'];
    }
    $message = str_replace('&gt;','>',$message);
    $message = str_replace('&lt;','<',$message);
    if ( $_POST['savenosend'] != 'Save' ) {
      $sentDb = " sent = '" . time() . "',numsent = '" . $x_ok . "',";
    }
    $query = "UPDATE " . $phpml['dbMsgs'] . "
                 SET subject = '" . addslashes($_POST['emailtitle']) . "',
                     body    = '" . addslashes($message) . "',
                     format  = '" . $tformat . "'," . $sentDb . "
                     listid  = '" . $_POST['frmWhichList'] . "'
               WHERE msgid   = " . $_POST['frmMsgId'];
  } else {
    if ($_POST['frmMsgId'] != '') {
      $message = $_POST['frmEditor'] . '<!--imgtrack-->';
    } else {
      $message = $_POST['frmEditor'];
    }
    $query = "INSERT INTO " . $phpml['dbMsgs'] . "
                (subject,body,
                 format,sent,numsent,
                 listid)
              VALUES
                ('" . addslashes($_POST['emailtitle']) . "','" . addslashes($message) . "',
                 '" . $tformat . "','" . time() . "','" . $x_ok . "',
                 '" . $_POST['frmWhichList'] . "')";
  }
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  if ($_POST['sendemail']) {
    echo $PHPML_LANG["sent"] . " (" . $xi . ") ... <br />";
  }
  echo "<a href=\"index.php?pg=campaigns\">" . $PHPML_LANG["click_continue"] . "</a><br />";
} elseif ( $_GET['proc'] == 'add' ) {
  $path        = $phpml['path_admin'] . '/rsrcs/tpl';
  $pathPreview = 'rsrcs/tpl';
  $dir_handle = @opendir($path) or die("Unable to open template directory<br />");
  echo "Select the template you wish to use<br /><br />";
  while ( $file = readdir($dir_handle) ) {
    if ( $file != "." && $file != ".." ) {
      $dirArray[] = $file;
    }
  }
  asort($dirArray);
  closedir($dir_handle);

  echo '<table border="0" cellspacing="1" cellpadding="0" id="table1">';
  echo '<tr>';
  echo '<td valign="top">';
  $noPreview = $pathPreview . '/nopreview.jpg';
  foreach ($dirArray as $key => $value) {
    if ( is_dir($pathPreview . '/' . $value) ) {
      $previewImg = $pathPreview . '/' . $value . '/preview.jpg';
      $previewDef = $pathPreview . '/preview.jpg';
      if ( file_exists($previewImg) ) {
        $imgPreview = $previewImg;
      } else {
        $imgPreview = $previewDef;
      }
      echo '<a style="text-decoration:underline;" href="index.php?pg=campaigns&proc=edit&tid=' . $value . '" onMouseOver="document.tplImage.src=\'' . $imgPreview . '\';" onMouseOut="document.tplImage.src=\'' . $noPreview . '\';">';
      echo $value . "</a><br />\n";
    }
  }
  echo '</td>';
  echo '<td><div style="width:20px;"></div></td>';
  echo '<td width="250" valign="top"><img src="' . $noPreview . '" name="tplImage"></td>';
  echo '</tr>';
  echo '</table>';
} elseif ( $_GET['proc'] == 'pgcpy' ) {
  if ( $_GET['id'] ) {
    $id = _copyRecord($_GET['id']);
    echo $PHPML_LANG["campaign"] . " ID " . $_GET['id']  . " " .$PHPML_LANG["copied"] . "<br>";
  } else {
    echo $PHPML_LANG["campaign"] . " ID " . $_GET['id']  . " " .$PHPML_LANG["copied_not"] . "<br>";
  }
  echo '<meta http-equiv="refresh" content="3;url=index.php?pg=campaigns" />';
} elseif ( $_GET['proc'] == 'edit' ) { // section to exit existing campaign
  if ( $_GET['tid'] ) {
    // copy the image to the upload directory and to the message images directory
    $fromDir = $phpml['path_admin'] . '/rsrcs/tpl/' . $_GET['tid'];
    // get a list of all images and copy them
    $dir_handle = @opendir($fromDir) or die("Unable to open template directory<br />");
    // copy only the HTML file so that we can get the new message ID number
    $newMsgId = '';
    while ( $file = readdir($dir_handle) ) {
      if ( $file != "." && $file != ".." ) {
        $extArry  = split('\.',$file);
        $extCount = count($extArry) - 1;
        if ( $extArry[$extCount] == 'htm' || $extArry[$extCount] == 'html' ) {
          if ( $extArry[1] == 'htm' || $extArry[1] == 'html' ) {
            // read file and get contents, then add to database as a new campaign
            $body    = addslashes(file_get_contents($fromDir . '/' . $file));
            if ( $_GET['tid'] == 'newsletter' ) {
              $body = str_replace('newsletter.png',$phpml['userURL'].'/newsletter.png',$body);
            }
            $subject = $_GET['tid'] . ' copy';
            $format  = 'H';
            $listid  = '1';
            $sql = "INSERT INTO " . $phpml['dbMsgs'] . "
                      (subject, body, format,listid)
                    VALUES
                      ('" . $subject . "','" . $body . "','" . $format . "','" . $listid . "')";
            $result     = mysql_query($sql);
            $newMsgId   = mysql_insert_id();
            $_GET['id'] = $newMsgId;
          }
        }
      }
    }
    rewinddir($dir_handle); // reset the handle to the beginning
    // copy everything except the HTML file (copied above)
    while ( $file = readdir($dir_handle) ) {
      if ( $file != "." && $file != ".." ) {
        $extArry  = split('\.',$file);
        $extCount = count($extArry) - 1;
        if ( $extArry[$extCount] == 'png' || $extArry[$extCount] == 'jpg' || $extArry[$extCount] == 'jpeg' || $extArry[$extCount] == 'gif' ) {
          if ( $extArry[0] != 'preview' ) {
            // copy image to $phpml['userdir'], excluding the preview
            copy($fromDir . '/' . $file, $phpml['userdir'] . '/' . $file);
            if ( $newMsgId != '' ) {
              if ( !file_exists($phpml['path_root'] . '/_msgimgs' . '/' . $newMsgId) ) {
                // create the directory since it doesn't exist
                if ( IS_WINDOWS ) {
                  mkdir($phpml['path_root'] . '/_msgimgs' . '/' . $newMsgId);
                } else {
                  mkdir($phpml['path_root'] . '/_msgimgs' . '/' . $newMsgId, 0777);
                }
              }
              copy($fromDir . '/' . $file, $phpml['path_root'] . '/_msgimgs' . '/' . $newMsgId . '/' . $file);
              // update the message database with the new link
              $body = stripslashes($body);
              preg_match_all("/(src|background)=\"(.*)\"/Ui", $body, $images);
              if(isset($images[2])) {
                foreach($images[2] as $i => $url) {
                  if (!preg_match('#^[A-z]+://#',$url)) {
                    $filename = basename($url);
                    $directory = dirname($url);
                    ($directory == '.')?$directory='':'';
                    $newimagelink = $phpml['path_root'] . '/_msgimgs/' . $newMsgId . '/' . $filename;
                    if ( strlen($basedir) > 1 && substr($basedir,-1) != '/') { $basedir .= '/'; }
                    if ( strlen($directory) > 1 && substr($directory,-1) != '/') { $directory .= '/'; }
                    $body = str_replace($images[2][$i], $newimagelink, $body);
                  }
                }
              }
              $sql = "UPDATE " . $phpml['dbMsgs'] . "
                         SET body = '" . $body . "'
                       WHERE msgid = '" . $newMsgId . "'";
              $result     = mysql_query($sql);
            }
          }
        }
      }
    }
    closedir($dir_handle);
  }
  if ($_GET['id'] != '') {
    $query  = "SELECT *
                 FROM " . $phpml['dbMsgs'] . "
                WHERE msgid    = " . $_GET['id'];
    $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
    $row    = mysql_fetch_assoc($result);
    $dbMsgID      = $row['msgid'];
    $dbSubject    = $row['subject'];
    $dbMessage    = $row['body'];
    $dbMessage    = str_replace('<!--imgtrack-->','',$dbMessage);
    $dbFormat     = $row['format'];
    if ($dbFormat == "T") {
      $dbFormat = "Text Only";
    } else {
      $dbFormat = "HTML and Text";
    }
    if ( $row['sent'] < 1 ) {
      $dbSent       = '&ndash;';
    } else {
      $dbSent       = date("F j, Y", $row['sent']);
    }
    $dbListID     = $row['listid'];
  }
  ?>
  <div class="tpl_table">
    <table class="tpl_listing tpl_form" width="100%" cellpadding="0" cellspacing="0">
      <tr><form action="index.php?pg=campaigns" method="post">
        <?php
        if ($dbListID != '') {
          echo '<input type="hidden" name="frmMsgId" value="' . $dbMsgID . '">';
        }
        ?>
        <th class="full" colspan="2"><?php echo $PHPML_LANG["compose_message"] . ' (ID #' . $dbMsgID . ')'; ?></th>
      </tr>
      <?php
      $sEditSubject = $dbSubject;
      if (isset($sEditSubject)) {
        $subject = $sEditSubject;
      } else {
        $subject = $PHPML_LANG["subject"];
      }
      $sEditMessage = $dbMessage;
      if (isset($sEditMessage)) {
        $message = $sEditMessage;
      } else {
        if (file_exists($phpml['path_root'] . "/" . $_SESSION['acp'] . "/defemail.html")) {
          $message = file_get_contents($phpml['path_root'] . "/" . $_SESSION['acp'] . "/defemail.html");
          $message = str_replace('newsletter.png', $phpml['url_admin'] . '/newsletter.png', $message);
        } else {
          $message = "Dear {firstname} {lastname},\n\nMy message to you is ...\n\n-------------------------------------\n<a href=\"{unsubscribe}\">Unsubscribe</a>\nYou registered on {reg_date} using IP address {ip} from remote host {remote_host}.";
        }
      }
      if ($phpml['path_base'] != '') {
        $defEdPath = '/' . $phpml['path_base'];
      } else {
        $defEdPath = '';
      }

      if ( $phpml['editorincl'] != '' ) {
        include($phpml['editorincl']);
      }
      echo "<tr>";
      if ( $dbListID == '' || $dbListID < 1 ) {
        $msgList = $_SESSION['def_list'];
      }

      echo "<td class=\"first\" valign=\"top\">" . $PHPML_LANG["which_list"] . "</td>\n";
      echo "<td class=\"last\">";
      $whichList = _getList($msgList);
      echo $whichList;
      echo "</td>\n";
      echo "</tr>";

      echo "<tr>";
      echo "<td class=\"first\">" . $PHPML_LANG["subject"] . "</td>\n";
      echo "<td class=\"last\">";
      echo "<input style=\"width:98%;\" type=\"text\" name=\"emailtitle\" size=\"80\" value=\"" . htmlspecialchars(stripslashes($subject)) . "\"></input>";
      echo "</td>\n";
      echo "</tr>";

      echo "<tr>";
      echo "<td colspan=\"2\" class=\"last\">";
      if ( $phpml['editor'] == 'spaw2' ) {
        $spaw = new SpawEditor("frmEditor", stripslashes($message));
        $spaw->show();
      } elseif ( $phpml['editor'] == 'ckeditor' ) {
        echo $phpml['editorinit'];
        echo '<textarea name="frmEditor" id="frmEditor" style="width: 100%; height: 200px; overflow: scroll;" rows="10" cols="10">' . stripslashes($message) . '</textarea>' . "\n";
        echo '<script type="text/javascript">' . "\n";
        echo '//<![CDATA[' . "\n";
        if ( $phpml['filemgr'] == 'kfm' ) {
          echo '  CKEDITOR.replace(\'frmEditor\',{' . "\n";
          echo '    filebrowserBrowseUrl: "' . $phpml['kfmpath'] . '",' . "\n";
          echo "    toolbar:[";
          echo "['NewPage','Preview'],['Cut','Copy','Paste','PasteText','PasteFromWord'],['Undo','Redo','-','SelectAll','RemoveFormat'],['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],['Image'],'/',";
          echo "['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],['Link','Unlink','Anchor'],['Table','HorizontalRule','SpecialChar'],'/',";
          echo "['Styles','Format','Font','FontSize'],['TextColor','BGColor'],['ShowBlocks','-','Source','-','Maximize']";
          echo "]\n";
          echo '  });' . "\n";
        } else {
          echo '  CKEDITOR.replace(\'frmEditor\',{' . "\n";
          echo "    toolbar:[";
          echo "['NewPage','Preview'],['Cut','Copy','Paste','PasteText','PasteFromWord'],['Undo','Redo','-','SelectAll','RemoveFormat'],['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],['Image'],'/',";
          echo "['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],['Link','Unlink','Anchor'],['Table','HorizontalRule','SpecialChar'],'/',";
          echo "['Styles','Format','Font','FontSize'],['TextColor','BGColor'],['ShowBlocks','-','Source','-','Maximize']";
          echo "]\n";
          echo '  });' . "\n";
        }
        echo '//]]>' . "\n";
        echo '</script>' . "\n";
      } elseif ( $phpml['editor'] == 'none' ) {
        $message = str_replace('>','&gt;',$message);
        $message = str_replace('<','&lt;',$message);
        echo '<textarea name="frmEditor" id="frmEditor" style="width: 100%; height: 200px; overflow: scroll;" rows="10" cols="10">' . stripslashes($message) . '</textarea>';
      }
      echo "</td>\n";
      echo "</tr>";

      echo "<tr>";
      echo "<td class=\"first\" valign=\"top\">" . $PHPML_LANG["email_format"] . "</td>\n";
      echo "<td class=\"last\">";
      echo '<select name="frmFormat">';
      echo '<option selected value="htmltext">' . $PHPML_LANG["email_htmltext"] . '</option>';
      echo '<option value="textonly">' . $PHPML_LANG["email_textonly"] . '</option>';
      echo '</select>';
      echo "</td>\n";
      echo "</tr>";

      echo "<tr class=\"bg\">";
      echo "<td colspan=\"2\" align=\"center\">";
      echo "<input type=\"submit\" name=\"savenosend\" value=\"" . $PHPML_LANG["save"] . "\">&nbsp;&nbsp;&nbsp;";
      echo "<input type=\"submit\" name=\"sendemail\" value=\"" . $PHPML_LANG["save"] . " &amp; " . $PHPML_LANG["send"] . "\">";
      echo "</td>";
      echo "</tr>";
    echo "</form></table>";
  echo "</div>";
} else {
  if ( isset($_POST['total_emails_processed']) ) {
    echo 'Emails processed: ' . $_POST['total_emails_processed'] . "<br />";
    echo 'Emails sent: ' . $_POST['total_emails_sent'] . "<br />";
    echo 'Errors: '  . $_POST['x_errors'] . "<br /><br />";
  }
  $query  = "SELECT *
               FROM " . $phpml['dbMsgs'] . "
              WHERE 1 = 1
           ORDER BY msgid DESC";
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  $num    = mysql_num_rows($result);
  if ($num) {
    ?>
    <div class="tpl_table">
      <table class="tpl_listing tpl_form" width="100%" cellpadding="0" cellspacing="0">
        <tr><form action="index.php?pg=campaigns&proc=del" method="post">
          <th class="first">ID</th>
          <th><?php echo $PHPML_LANG["subject"]; ?></th>
          <th>Format</th>
          <th>Sent</th>
          <th>List</th>
          <th class="last" colspan="2">Action</th>
        </tr>
        <?php
        $intNumber = 1;
        while ( $row    = mysql_fetch_assoc($result) ) {
          $dbMsgID      = $row['msgid'];
          $dbSubject    = $row['subject'];
          $dbFormat     = $row['format'];
          if ($dbFormat == "T") {
            $dbFormat = "Text Only";
          } else {
            $dbFormat = "HTML and Text";
          }
          if ( $row['sent'] < 1 ) {
            $dbSent       = '&ndash;';
          } else {
            $dbSent       = date("F j, Y", $row['sent']);
            // get number of emails sent
            $queryc    = "SELECT * FROM " . $phpml['dbTrack'] . " WHERE mid = '" .$dbMsgID . "'";
            $resultc   = mysql_query($queryc) or die($PHPML_LANG["error_query"] . mysql_error());
            $eopened   = mysql_num_rows($resultc);
          }
          $dbNumSent    = $row['numsent'];
          $dbListID     = $row['listid'];
          // get list name
          $queryl  = "SELECT *
                        FROM " . $phpml['dbLists'] . "
                       WHERE listid    = " . $dbListID;
          $resultl = mysql_query($queryl) or die($PHPML_LANG["error_query"] . mysql_error());
          $rowl = mysql_fetch_assoc($resultl);
          $rowTitle = $rowl['title'];
          echo "<tr";
          echo ($intNumber % 2 == 0 ) ? ' class="bg"' : '';
          echo ">\n";
          echo "<td class=\"first\">" . $dbMsgID;
          echo "</td>\n";
          echo "<td>" . $dbSubject . "</td>\n";
          echo "<td align=\"center\">" . $dbFormat . "</td>\n";
          echo "<td align=\"center\">";
          echo $dbSent;
          echo "</td>\n";
          echo "<td align=\"center\">";
          echo $rowTitle;
          echo "</td>\n";
          echo "<td class=\"last\" style=\"text-align:center;\"><input name=\"frmDelete[" . $dbMsgID . "]\" type=\"checkbox\" value=\"ON\"";
          echo "/></td>\n";
          echo "<td>";
          if ($dbSent == '&ndash;') {
            echo "<a href=\"index.php?pg=campaigns&proc=edit&id=$dbMsgID\"><img border=\"0\" src=\"appimgs/page_edit.png\" alt=\"" . $PHPML_LANG["edit"] . "\" title=\"" . $PHPML_LANG["edit"] . "\"></a>&nbsp;&nbsp;";
            echo "<a href=\"index.php?pg=campaigns&proc=send&id=$dbMsgID\"><img border=\"0\" src=\"appimgs/email_go.png\" alt=\"" . $PHPML_LANG["send"] . ' ' . $PHPML_LANG["to"] . ' ' . $PHPML_LANG["listid"] . ' ' . $_SESSION['def_list'] . "\" title=\"" . $PHPML_LANG["send"] . ' ' . $PHPML_LANG["to"] . ' ' . _getListName($_SESSION['def_list']) . ' ' . $PHPML_LANG["list"] . "\"></a>&nbsp;&nbsp;";
          } else {
            $title = $PHPML_LANG["statistics"];
            $tip  = '<table width=&quot;250&quot; border=&quot;0&quot; cellpadding=&quot;1&quot; style=&quot;border-collapse:collapse;&quot;>';
            $tip .= '<tr><td align=&quot;right&quot;>' . $PHPML_LANG["message"] . ' ' . $PHPML_LANG["sent"] . ': </td><td>' . $dbSent . '</td></tr>';
            $tip .= '<tr><td align=&quot;right&quot;>' . $PHPML_LANG["sentnum"] . ': </td><td>' . $dbNumSent . '</td></tr>';
            $tip .= '<tr><td align=&quot;right&quot;>' . $PHPML_LANG["openpercentage"] . ': </td><td>' . _format_percent($eopened,$dbNumSent) . '</td></tr>';
            $tip .= '</table>';
            echo "<a href=\"index.php?pg=campaigns&proc=pgcpy&id=$dbMsgID\"><img border=\"0\" src=\"appimgs/page_copy.png\" alt=\"" . $PHPML_LANG["copy"] . "\" title=\"" . $PHPML_LANG["copy"] . "\"></a>&nbsp;&nbsp;";
            echo "<a href=\"index.php?pg=stats&id=$dbMsgID\" onmouseover=\"Tip('" . $tip . "',TITLE,'" . $title . "')\" onmouseout=\"UnTip()\"><img border=\"0\" src=\"appimgs/chart_bar.png\" alt=\"" . $PHPML_LANG["statistics"] . "\" title=\"" . $PHPML_LANG["statistics"] . "\"></a>";
          }
          echo "</td>\n";
          echo "</tr>\n";
          $intNumber++;
        }
        echo "<tr";
        echo ($intNumber % 2 == 0 ) ? ' class="bg"' : '';
        echo ">\n";
        echo "<td colspan=\"9\" align=\"center\"><input type=\"submit\" name=\"redo\" value=\"" . $PHPML_LANG["deleteselected"] . "\">";
        echo "<br /><small>" . $PHPML_LANG["deleteselectedextra"] . "</small>";
        echo "</td>";
        echo "</tr>";
        echo "</form></table>";
    echo "</div>";
  }
}
echo '</div>';

$pgArr['button']   = '<a href="index.php?pg=campaigns&proc=add" class="button"><img border="0" src="appimgs/add.png" title="' . $PHPML_LANG["add_new_list"] . '"></a>';
$pgArr['caption']  = $PHPML_LANG["campaigns"];
$pgArr['contents'] = ob_get_contents();
$pgArr['help']     = "{applicationname}<br />
  {email}<br />
  {ip}<br />
  {firstname}<br />
  {lastname}<br />
  {mailinglist}<br />
  {msgid}<br />
  {onlineviewurl}<br />
  {reg_date}<br />
  {remote_host}<br />
  {unsubscribe}<br />
  are variables that will get substituted with the subscriber&#039;s data at time of sending.
  Copy and paste into your eMessage<br />";

if ( $_GET['proc'] == 'edit' ) {
$pgArr['help']    .= "<hr />
  The Mailing List you will be sending this eMessage to is displayed both at the top
  left in the Default panel, and you can choose a different list by highlighting
  your choice at the top of the center (edit) panel.
  <hr />
  When you are finished editing the eMessage, you have a choice of cliking on:<br />
  &ndash; Save = this will save the eMessage and NOT send<br />
  &ndash; Save &amp; Send = this will save the eMessage and take you to the next screen to Email
  your eMessage to the mailing list you select.<br />";
}
ob_end_clean();
echo getSkin ($pgArr);
?>
