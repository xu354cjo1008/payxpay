<?php
/*~ _acp-ml/inc.subscribers.php
.---------------------------------------------------------------------------.
|  Software: PHPMailer-ML - PHP mailing list                                |
|   Version: 1.8.1                                                          |
|   Contact: via sourceforge.net support pages (also www.codeworxtech.com)  |
|      Info: http://phpmailer.sourceforge.net                               |
|   Support: http://sourceforge.net/projects/phpmailer/                     |
| ------------------------------------------------------------------------- |
|    Author: Andy Prevost (project admininistrator)                         |
| Copyright (c) 2004-2009, Andy Prevost. All Rights Reserved.               |
| ------------------------------------------------------------------------- |
|   License: Distributed under the Lesser General Public License (LGPL)     |
|            http://www.gnu.org/copyleft/lesser.html                        |
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

if ($_POST['change_def_list']) {
  $def_list = $_POST['change_def_list'];
  $_SESSION['def_list'] = $def_list;
}
if ($_GET['proc'] == "del") {
  foreach ($_POST['frmDelete'] as $key => $value) {
    $query = "DELETE FROM " . $phpml['dbMembers'] . "
                WHERE memberid = $key";
    $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
    echo '#' . $key  . " " .$PHPML_LANG["deleted"] . "<br>";
  }
  echo '<meta http-equiv="refresh" content="3;url=index.php?pg=subscribers" />';
} elseif ($_GET['proc'] == "addrec") {
  if ( isset($_POST['frmEmail']) && $_POST['frmEmail'] != '' ) {
    $frmWhichList = $_POST[frmWhichList];
    $firstname    = $_POST[frmFirstName];
    $lastname     = $_POST[frmLastname];
    $email        = $_POST[frmEmail];
    $regdate      = time();
    $query = "INSERT INTO " . $phpml['dbMembers'] . "
                (listid,firstname,lastname,email,confirmed,approved,regdate,IP,RH)
              VALUES
                ('$frmWhichList','$firstname','$lastname','$email','1','1','$regdate','127.0.0.1','localhost')";
    mysql_query($query);
    echo $PHPML_LANG["useradded"] . '<br />';
    echo '<meta http-equiv="refresh" content="3;url=index.php?pg=subscribers" />';
  } else {
    if ( $dbListID == '' || $dbListID < 1 ) {
      $msgList = $_SESSION['def_list'];
    }
    echo '<strong>' . $PHPML_LANG["useradd"] . '</strong><br />';
    echo '<form name="zForm" action="index.php?pg=subscribers&proc=addrec" method="post">';
    echo '<table class="tpl_listing tpl_form" cellpadding="0" cellspacing="0">';
    echo '<tr><td class="first" valign="top">' . $PHPML_LANG["which_list"] . '</td><td class="last">' . _getList($msgList) . '</td></tr>';
    echo '<tr><td align="right">First Name</td><td><input type="text" name="frmFirstName"></td></tr>';
    echo '<tr><td align="right">Last Name</td><td><input type="text" name="frmLastname"></td></tr>';
    echo '<tr><td align="right">Email Address</td><td><input type="text" name="frmEmail"></td></tr>';
    echo '<tr><td align="center" colspan="2"><input type=submit value="Add Subscriber"></td></tr>';
    echo '</table>';
    echo"</form>";
    echo '<small>Subscriber record will be marked as confirmed and approved</small><br />';
  }
} else {
  echo '<div align="left" style="width:100%;">';
  $whichList = _getDefList($_SESSION['def_list']);
  echo "<form method=\"post\">" . $whichList . "</form>";
  echo "<img src=\"appimgs/spacer.gif\" width=\"400\" height=\"5\">";
  echo '</div>';

  if ($_SESSION['def_list'] != '') {
    $listToUse = ' WHERE listid = ' . $_SESSION['def_list'];
  } else {
    $listToUse = '';
  }
  $query  = "SELECT *
               FROM " . $phpml['dbMembers'] . $listToUse;
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  $num    = mysql_num_rows($result);
  if ($num) {
    ?>
    <div class="tpl_table">
      <table width="100%" class="tpl_listing tpl_form" cellpadding="0" cellspacing="0">
        <tr><form action="index.php?pg=subscribers&proc=del" method="post">
          <th class="first"><?php echo $PHPML_LANG["name_first_s"]; ?></th>
          <th><?php echo $PHPML_LANG["name_last_s"]; ?></th>
          <th><?php echo $PHPML_LANG["name_email"]; ?></th>
          <th><?php echo $PHPML_LANG["name_regdate"]; ?></th>
          <th class="last"><?php echo $PHPML_LANG["action"]; ?></th>
        </tr>
    <?php
    $intNumber = 1;
    while ( $row    = mysql_fetch_assoc($result) ) {
      $dbMemID      = $row['memberid'];
      $dbFirstName  = $row['firstname'];
      $dbLastName   = $row['lastname'];
      $dbEmail      = $row['email'];
      $dbRegi       = date("F j Y", $row['regdate']);
      $dbConfirmed  = $row['confirmed'];
      $dbConfirmed  = ('1') ? "Y" : "N";
      $dbApproved   = $row['approved'];
      $dbApproved   = ('1') ? "Y" : "N";
      $dbDeleted    = $row['deleted'];
      $dbDeleted    = ('1') ? "Y" : "N";
      if ($row['deldate'] != '0' && $row['deldate'] != '') {
        $dbDelDate   = date("F j Y", $row['deldate']);
      } else {
        $dbDelDate   = "&nbsp;";
      }
      $dbIP        = $row['IP'];
      $dbHost      = $row['RH'];
      $title = $dbLastName . ', ' . $dbFirstName;
      $tip  = '<table width=&quot;250&quot; border=&quot;0&quot; cellpadding=&quot;1&quot; style=&quot;border-collapse:collapse;&quot;>';
      $tip .= '<tr><td align=&quot;right&quot;>' . $PHPML_LANG["name_id"] . ': </td><td>' . $dbMemID . '</td></tr>';
      $tip .= '<tr><td align=&quot;right&quot;>' . $PHPML_LANG["name_email"] . ': </td><td>' . str_replace('[at]','&#64;',$dbEmail) . '</td></tr>';
      $tip .= '<tr><td align=&quot;right&quot;>' . $PHPML_LANG["name_regdate"] . ': </td><td>' . $dbRegi . '</td></tr>';
      $tip .= '<tr><td align=&quot;right&quot;>' . $PHPML_LANG["Confirmed_wd"] . ': </td><td>' . $dbConfirmed . '</td></tr>';
      $tip .= '<tr><td align=&quot;right&quot;>' . $PHPML_LANG["Approved_wd"] . ': </td><td>' . $dbApproved . '</td></tr>';
      if ( $dbDelDate != "&nbsp;" ) {
        $tip .= '<tr><td align=&quot;right&quot;>' . $PHPML_LANG["delete_date"] . ': </td><td>' . $dbDelDate . '</td></tr>';
      }
      $tip .= '</table>';
      echo "<tr";
      echo ($intNumber % 2 == 0 ) ? ' class="bg"' : '';
      echo ">\n";
      echo "<td align=\"left\" style=\"font-size:10px;\">" . $dbFirstName . "</td>\n";
      echo "<td align=\"left\" style=\"font-size:10px;\">" . $dbLastName . "</td>\n";
      echo "<td class=\"first\" style=\"font-size:10px;\">";
      echo "<a href=\"\" onmouseover=\"Tip('" . $tip . "',TITLE,'" . $title . "')\" onmouseout=\"UnTip()\">" . str_replace('[at]','&#64;',$dbEmail) . "</a>";
      echo "</td>\n";
      echo "<td align=\"center\" style=\"font-size:10px;\">" . $dbRegi . "</td>\n";
      echo "<td class=\"last\" align=\"center\" style=\"font-size:10px;\"><input name=\"frmDelete[" . $dbMemID . "]\" type=\"checkbox\" value=\"ON\"";
        echo $dbDeleted   == (1) ? "checked" : "";
        echo "/></td>\n";
      echo "</tr>\n";
      $intNumber++;
    }
    echo "<tr";
    echo ($intNumber % 2 == 0 ) ? ' class="bg"' : '';
    echo ">\n";
    echo "<td colspan=\"8\" align=\"center\"><input type=\"submit\" name=\"redo\" value=\"" . $PHPML_LANG["deleteselected"] . "\"></td>";
    echo "</tr>";
    echo "</form></table>";
    echo "</div>";
  }
}
echo '</div>';

if ( file_exists($phpml['modules'] . 'quickcsv/inc.db.php') ) {
  $pgArr['button'] = '<a href="' . $phpml['modules'] . 'quickcsv/csv2mysql.php" class="button"><img border="0" src="appimgs/database_add.png" title="' . $PHPML_LANG["import"] . '"></a>';
} else {
  $pgArr['button'] = '<a href="index.php?pg=upld" class="button"><img border="0" src="appimgs/database_add.png" title="' . $PHPML_LANG["import"] . '"></a>';
}
$pgArr['button'] .= '<a href="index.php?pg=subscribers&proc=addrec" class="button"><img border="0" src="appimgs/user_add.png" title="' . $PHPML_LANG["useradd"] . '"></a>';
$pgArr['caption'] = $PHPML_LANG["subscriber_records"];
$pgArr['contents'] = ob_get_contents();
$pgArr['help']     = "Manage your subscribers. You have the ability to:<br />
  Add<br />
  Delete<br />
  If a customer wishes to have their record
  edited, they will have to first unsubscribe,
  then recreate a new account.";
ob_end_clean();
echo getSkin ($pgArr);

function _getDefList($listid='') {
  global $phpml, $PHPML_LANG;

  $query = "SELECT listid, title
              FROM " . $phpml['dbLists'] . "
             WHERE display = '1'";
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  $num    = mysql_num_rows($result);
  if ($num) {
    $optBuild = $PHPML_LANG["mailinglist"] . ': <select name="change_def_list" onchange="this.form.submit()">';
    while ( $row    = mysql_fetch_assoc($result) ) {
      $dbListID     = $row['listid'];
      $dbTitle      = $row['title'];
      $optBuild .= '<option';
      $optBuild .= ($dbListID == $listid) ? ' selected' : '';
      $optBuild .= ' value="' . $dbListID . '">' . $dbTitle . '</option>';
    }
    $optBuild .= '</select>';
    return $optBuild;
  }
}

?>
