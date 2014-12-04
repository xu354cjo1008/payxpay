<?php
/*~ _acp-ml/inc.stats.php
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

ob_start();

echo '<div align="center">';
echo '<br />';

$eid   = $_GET['eid'];
$mid   = $_GET['mid'];
$msgid = $_GET['id'];
$pgArr['caption'] = '';

$query = "SELECT *
            FROM " . $phpml['dbMsgs'];
if (isset($_GET['id'])) {
  $query .= " WHERE msgid='" . $msgid . "'";
}
$result    = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
$row       = mysql_fetch_assoc($result);
$numsent   = $row['numsent'];
$queryc    = "SELECT * FROM " . $phpml['dbTrack'] . " WHERE mid = '" . $msgid . "'";
$resultc   = mysql_query($queryc) or die($PHPML_LANG["error_query"] . mysql_error());
$eopened   = mysql_num_rows($resultc);
$dayopened = date("F j, Y", $row['sent']);
$gdays     = date("Y-m-d", $row['sent']);

echo '<div align="left" style="width:550px;">';
$baseStats  = $PHPML_LANG["message"] . ' ' . $PHPML_LANG["sent"] . ': ';
$baseStats .= $dayopened . ' (' . _getElapsedDays($gdays) . ' ' . $PHPML_LANG["daysago"] . ')<br />';
$baseStats .= $PHPML_LANG["sentnum"] . ': ' . $eopened . '<br />';
$baseStats .= $PHPML_LANG["openpercentage"] . ': ' . _format_percent($eopened,$numsent) . '<br />';
echo $baseStats;

echo '<table width="550" border="1" cellpadding="2" style="border-collapse:collapse;">';
if ($pgArr['caption'] == '') {
  $pgArr['caption'] = $PHPML_LANG["statistics"] . ': ' . $eopened . ' ' . $PHPML_LANG["opens"];
}
while ($rowm = mysql_fetch_assoc($resultc)) {
  $odaysarr  = split(' ',$rowm['atime']);
  $odays     = $odaysarr[0];
  $querym  = "SELECT * FROM " . $phpml['dbMembers'] . " WHERE memberid = '" . $rowm['eid'] . "'";
  $resultm = mysql_query($querym) or die($PHPML_LANG["error_query"] . mysql_error());
  $rowr    = mysql_fetch_assoc($resultm);
  echo '<tr><td>' . $rowr['email'] . '</td><td>' . $rowr['lastname'] . ', ' . $rowr['firstname'] . '</td><td>' . $rowm['ipaddr'] . '</td><td>' . $rowm['atime'] . '</td><td>' . _getElapsedDays($odays) . ' ' . $PHPML_LANG["days"] . '</td></tr>';
}
echo '</table>';
echo '</div>';
echo '</div>';

if ($pgArr['caption']=='') {
  $pgArr['caption']  = $PHPML_LANG["statistics"];
}
$pgArr['contents'] = ob_get_contents();
$pgArr['help']     = "Email Opened Statistics";
ob_end_clean();
echo getSkin ($pgArr);

?>