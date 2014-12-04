<?php
/*~ _acp-ml/inc.functions.php
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

/* NO NEED TO CHANGE ANYTHING BELOW HERE */

defined('_WRX') or die( _errorMsg('Restricted access') );

$phpml['dbMembers']      = 'phpml_members'; // table to hold member data
$phpml['dbLists']        = 'phpml_lists';   // table to hold lists data
$phpml['dbMsgs']         = 'phpml_msgs';    // table to hold campaign messages
$phpml['dbTrack']        = 'phpml_track';   // table to hold email tracking

if (!defined('DBPASSWD')) {define('DBPASSWD', DBPASS);}
$link1 = mysql_connect(DBHOST,DBUSER,DBPASS);
if (!$link1) {
  die('Could not connect: ' . mysql_error());
}
$db1   = mysql_select_db(DBNAME, $link1);
if (!$db1) {
  die('Unable to select database' . mysql_error());
}

$query  = "SELECT *
             FROM " . $phpml['dbMembers'];
$result = mysql_query($query);
if (!$result) {
  $queryc = 'CREATE TABLE IF NOT EXISTS `' . $phpml['dbMembers'] . '` (
    `memberid` int(8) NOT NULL auto_increment,
    `listid` int(8) NOT NULL default \'1\',
    `firstname` varchar(255) NOT NULL default \'\',
    `lastname` varchar(255) NOT NULL default \'\',
    `city` varchar(255) NOT NULL default \'\',
    `state` varchar(255) NOT NULL default \'\',
    `country` char(3) NOT NULL default \'\',
    `message` tinytext NOT NULL,
    `email` varchar(255) NOT NULL default \'\',
    `regdate` int(11) NOT NULL default \'0\',
    `confirmed` enum(\'0\',\'1\') NOT NULL default \'0\',
    `approved` enum(\'0\',\'1\') NOT NULL default \'0\',
    `deleted` enum(\'0\',\'1\') NOT NULL default \'0\',
    `deldate` int(11) NOT NULL default \'0\',
    `IP` varchar(31) NOT NULL default \'\',
    `RH` varchar(255) NOT NULL default \'\',
    PRIMARY KEY  (`memberid`)
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1;';
  $resultc = mysql_query($queryc) or die("Unable to execute query - one");
  $queryi = 'INSERT INTO `phpml_members` (`memberid`, `listid`, `firstname`, `lastname`, `city`, `state`, `country`, `message`, `email`, `regdate`, `confirmed`, `approved`, `deleted`, `deldate`, `IP`, `RH`) VALUES
    (1, 1, \'admin\', \'admin\', \'\', \'\', \'\', \'\', \'\', 0, \'0\', \'0\', \'0\', 0, \'\', \'\');';
  $resulti = mysql_query($queryi) or die("Unable to execute query - two");
  $result  = mysql_query($query);
}
for ($i=0; $i < mysql_num_fields($result); $i++) { //Table Header
  $field_array[] = mysql_field_name($result, $i);
}
if (!in_array("city", $field_array)) {
  $queryinsert = "ALTER TABLE `" . $phpml['dbMembers'] . "` ADD `city` varchar(255) NOT NULL default '' AFTER lastname;";
  mysql_query($queryinsert) or die (mysql_error());
}
if (!in_array("state", $field_array)) {
  $queryinsert = "ALTER TABLE `" . $phpml['dbMembers'] . "` ADD `state` varchar(255) NOT NULL default '' AFTER city;";
  mysql_query($queryinsert) or die (mysql_error());
}
if (!in_array("country", $field_array)) {
  $queryinsert = "ALTER TABLE `" . $phpml['dbMembers'] . "` ADD `country` varchar(3) NOT NULL default '' AFTER state;";
  mysql_query($queryinsert) or die (mysql_error());
}
if (!in_array("message", $field_array)) {
  $queryinsert = "ALTER TABLE `" . $phpml['dbMembers'] . "` ADD `message` tinytext NOT NULL AFTER country;";
  mysql_query($queryinsert) or die (mysql_error());
}

$query  = "SELECT *
             FROM " . $phpml['dbLists'];
$result = mysql_query($query);
if (!$result) {
  $queryc = 'CREATE TABLE IF NOT EXISTS `' . $phpml['dbLists'] . '` (
    `listid` int(8) NOT NULL auto_increment,
    `listowner` varchar(255) NOT NULL default \'\',
    `listemail` varchar(255) NOT NULL default \'\',
    `title` varchar(255) default NULL,
    `description` varchar(255) default NULL,
    `display` enum(\'0\',\'1\') NOT NULL default \'1\',
    PRIMARY KEY  (`listid`)
  ) ENGINE=MyISAM  DEFAULT CHARSET=latin1;';
  $resultc = mysql_query($queryc) or die("Unable to execute query");
  $queryi = 'INSERT INTO phpml_lists (listid, listowner, listemail, title, description, display) VALUES
      (1, \'' . $phpml['FromName'] . '\', \'' . $phpml['FromAddy'] . '\', \'Newsletter\', \'Default newsletter list.\', \'1\');';
  $resulti = mysql_query($queryi) or die("Unable to execute query - two");
}
$query  = "SELECT *
             FROM " . $phpml['dbMsgs'];
$result = mysql_query($query);
if (!$result) {
  $queryc = 'CREATE TABLE IF NOT EXISTS `' . $phpml['dbMsgs'] . '` (
    `msgid` int(11) NOT NULL auto_increment,
    `subject` varchar(255) NOT NULL default \'\',
    `body` longtext NOT NULL,
    `format` enum(\'H\',\'T\') NOT NULL default \'H\',
    `sent` int(11) NOT NULL default \'0\',
    `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
    `listid` int(8) NOT NULL default \'1\',
    PRIMARY KEY  (`msgid`)
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1;';
  $resultc = mysql_query($queryc) or die("Unable to execute query - three");
}
for ($i=0; $i < mysql_num_fields($result); $i++) { //Table Header
  $field_array[] = mysql_field_name($result, $i);
}
if (!in_array("numsent", $field_array)) {
  $queryinsert = "ALTER TABLE `" . $phpml['dbMsgs'] . "` ADD `numsent` int(8) NOT NULL default '0' AFTER sent;";
  mysql_query($queryinsert) or die (mysql_error());
}

$query  = "SELECT *
             FROM " . $phpml['dbTrack'];
$result = mysql_query($query);
if (!$result) {
  $queryc = 'CREATE TABLE IF NOT EXISTS `' . $phpml['dbTrack'] . '` (
    `trackid` int(11) NOT NULL auto_increment,
    `eid` varchar(64) NOT NULL default \'\',
    `mid` varchar(64) NOT NULL default \'\',
    `ipaddr` varchar(16) NOT NULL default \'\',
    `atime` timestamp(14) NOT NULL,
    PRIMARY KEY  (`trackid`)
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1;';
  $resultc = mysql_query($queryc) or die("Unable to execute query - four");
}

/* function to load PHPMailer
 * and create a subclass
 */
function _load_PHPMailer() {
  global $phpml;

  require_once($phpml['PHPMailer_path'] . "/class.phpmailer.php");
  require_once($phpml['PHPMailer_path'] . "/class.html2text.php");

  class MyMailer extends PHPMailer {   // new subclass MyMailer
    // Set default variables for all new objects
    var $From;
    var $FromName;
    var $Mailer;
    var $WordWrap;
    var $Host;
    var $SMTPAuth;
    var $Username;
    var $Password;
    var $Port;

    function MyMailer() {
      global $phpml;
      $this->From     = $phpml['FromAddy'];
      $this->FromName = $phpml['FromName'];
      $this->AddReplyTo($phpml['FromAddy'], $phpml['FromName']);
      $this->Mailer   = $phpml['SendType'];
      if ($this->Mailer == "smtp") {
        $this->Port     = $phpml['SMTPport'];
        $this->Host     = $phpml['SMTPhost'];
        $this->SMTPAuth = $phpml['SMTPauth'];
        if ($this->SMTPAuth) {
          $this->Username = $phpml['SMTPusername'];
          $this->Password = $phpml['SMTPpassword'];
        }
        $this->SMTPKeepAlive = true;
      }
    }
  }
}

/* function to get the user"s IP address,
** even if behind a proxy - works with ISAPI mode
*/
function getIP() {
  if (isSet($_SERVER)) {
    if (isSet($_SERVER["HTTP_X_FORWARDED_FOR"])) {
      $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } elseif (isSet($_SERVER["HTTP_CLIENT_IP"])) {
      $realip = $_SERVER["HTTP_CLIENT_IP"];
    } else {
      $realip = $_SERVER["REMOTE_ADDR"];
    }
  } else {
    if ( getenv( "HTTP_X_FORWARDED_FOR" ) ) {
      $realip = getenv( "HTTP_X_FORWARDED_FOR" );
    } elseif ( getenv( "HTTP_CLIENT_IP" ) ) {
      $realip = getenv( "HTTP_CLIENT_IP" );
    } else {
      $realip = getenv( "REMOTE_ADDR" );
    }
  }
  return $realip;
}

function getSkin ($pgArr, $which='') {
  global $PHPML_LANG, $phpml;
  global $appVar;
  global $listid;

  if ($which == '') {
    $which = 'tpl.html';
  }

  $filename = $which;
  $fd = fopen ($filename, "r");
  $contents = fread ($fd, filesize ($filename));
  fclose ($fd);

  if ( $pgArr['help'] == '' ) {
    $pgArr['help'] = $PHPML_LANG["no_display"] . "<br />";
  }

  if ( $pgArr['contents'] == '' ) {
    $pgArr['contents'] = $PHPML_LANG["no_display"] . "<br />";
  }

  if ( $pgArr['button'] == '' ) {
    $pgArr['button'] = '';
  }

  // get default values
  $query  = "SELECT *
               FROM " . $phpml['dbLists'] . "
              WHERE listid    = " . $_SESSION['def_list'];
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  $row = mysql_fetch_assoc($result);
  $phpml['def_list']   = $row['title'];
  $phpml['def_listid'] = $row['listid'];
  $phpml['def_owner']  = $row['listowner'];
  $query  = "SELECT *
               FROM " . $phpml['dbMembers'] . "
              WHERE listid = '" . $_SESSION['def_list'] . "'
                AND confirmed = '1'
                AND deleted   = '0'";
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  $num    = mysql_num_rows($result);
  $defaults  = '<table width="100%">';
  $mlists    = '';
  $defaults .= '<tr><td align="right" class="text_default">' . $PHPML_LANG["list"] . ':</td><td width="99%" class="text_default">' . $phpml['def_list'] . '</td></tr>';
  $defaults .= '<tr><td align="right" class="text_default">' . $PHPML_LANG["listid"] . ':</td><td width="99%" class="text_default">' . $phpml['def_listid'] . '</td></tr>';
  $defaults .= '<tr><td align="right" class="text_default">' . $PHPML_LANG["owner"] . ':</td><td width="99%" class="text_default">' . $phpml['def_owner'] . '</td></tr>';
  $defaults .= '<tr><td align="right" class="text_default">' . $PHPML_LANG["Confirmed_hd"] . ':</td><td width="99%" class="text_default">' . $num . '</td></tr>';
  $defaults .= '<tr><td align="right" class="text_default">' . $PHPML_LANG["MT_hd"] . ':</td><td width="99%" class="text_default">';
  if ( $phpml['SendType'] == 'smtp' ) {
    $defaults .= 'SMTP';
  } elseif ( $phpml['SendType'] == 'sendmail' ) {
    $defaults .= 'Sendmail';
  } else {
    $defaults .= 'PHP mail()';
  }
  $defaults .= '</td></tr>';
  if ( $_GET['pg'] != 'about' ) {
    $query  = "SELECT *
                 FROM " . $phpml['dbLists'];
    $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
    $ii=0;
    while($row = mysql_fetch_assoc($result)) {
      $phpml['this_list']   = $row['title'];
      $phpml['this_listid'] = $row['listid'];
      $querym  = "SELECT *
                   FROM " . $phpml['dbMembers'] . "
                  WHERE listid = '" . $phpml['this_listid'] . "'
                    AND confirmed = '1'
                    AND deleted   = '0'";
      $resultm = mysql_query($querym) or die($PHPML_LANG["error_query"] . mysql_error());
      $num     = mysql_num_rows($resultm);
      if ( $ii == 0 ) {
        $defaults .= '<tr><td align="right" class="text_default">' . $PHPML_LANG["lists"] . ':</td><td width="99%" class="text_default">' . $phpml['this_list'] . ' (' . $num . ')</td></tr>';
      } else {
        $defaults .= '<tr><td align="right" class="text_default">&nbsp;</td><td width="99%" class="text_default">' . $phpml['this_list'] . ' (' . $num . ')</td></tr>';
      }
      $ii++;
      $mlists .= '<a href="index.php?pg=lists">' . $phpml['this_list'] . ' (' . $num . ')</a><br />';
    }
  }
  $defaults .= '</table>';
  $mcampaigns = '';

  $query  = "SELECT *
               FROM " . $phpml['dbMsgs'];
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  while($row = mysql_fetch_assoc($result)) {
    $dbSubject    = $row['subject'];
    $mcampaigns  .= '<a href="index.php?pg=campaigns">' . $dbSubject . '</a><br />';
  }
  // END get default values
  $qcsvLink = '<a href="' . $phpml['modules'] . 'quickcsv/csv2mysql.php">QuickCSV</a>';

  $contents = eregi_replace ("<!--defaults-->",      $defaults,                   $contents);
  $contents = eregi_replace ("<!--button-->",        $pgArr['button'],            $contents);
  $contents = eregi_replace ("<!--contents-->",      $pgArr['contents'],          $contents);
  $contents = eregi_replace ("<!--caption-->",       $pgArr['caption'],           $contents);
  $contents = eregi_replace ("<!--help-->",          $pgArr['help'],              $contents);
  $contents = eregi_replace ("<!--title-->",         $pgArr['title'],             $contents);
  $contents = eregi_replace ("<!--meta-->",          $pgArr['meta'],              $contents);
  $contents = eregi_replace ("<!--appimgs-->",       $phpml['url_admin'] . '/appimgs',     $contents);
  $contents = eregi_replace ("<!--apppath-->",       $phpml['path_admin'],        $contents);

  $contents = eregi_replace ("<!--aboutus-->",       $PHPML_LANG["aboutus"],      $contents);
  $contents = eregi_replace ("<!--profile-->",       $PHPML_LANG["profile"],      $contents);
  $contents = eregi_replace ("<!--campaigns-->",     $PHPML_LANG["campaigns"],    $contents);
  $contents = eregi_replace ("<!--mcampaigns-->",    $mcampaigns,                 $contents);
  $contents = eregi_replace ("<!--configuration-->", $PHPML_LANG["settings"],     $contents);
  $contents = eregi_replace ("<!--lists-->",         $PHPML_LANG["mailinglists"], $contents);
  $contents = eregi_replace ("<!--mlists-->",        $mlists,                     $contents);
  $contents = eregi_replace ("<!--subscribers-->",   $PHPML_LANG["subscribers"],  $contents);
  $contents = eregi_replace ("<!--quickcsv-->",      $qcsvLink,                   $contents);

  ob_start();
  eval("?>".$contents."<?php ");
  $contents = ob_get_contents();
  ob_end_clean();

  return $contents;
}

function _getList($listid='') {
  global $phpml;

  if ( trim($listid) == '' ) {
    $listid  = $_SESSION['def_list'];
  }

  $query = "SELECT listid, title
              FROM " . $phpml['dbLists'] . "
             WHERE display = '1'";
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  $num    = mysql_num_rows($result);
  if ($num) {
    //$optBuild = '<select class="name" name="frmWhichList">'; // select single list
    if ( basename($_SERVER["SCRIPT_NAME"]) == 'subscripe.php' ) { // used only on subscribe page
      $optBuild = '<select class="name" size="5" name="frmWhichList[]" multiple>'; // select multiple lists
    } else {
      $optBuild = '<select class="name" size="5" name="frmWhichList">'; // select list
    }
    while ( $row    = mysql_fetch_assoc($result) ) {
      $dbListID     = $row['listid'];
      $dbTitle      = $row['title'];
      $optBuild .= '<option';
      if ( $dbListID == $listid ) {
        $optBuild .= ' selected';
      }
      $optBuild .= ' value="' . $dbListID . '">' . $dbTitle . '</option>';
    }
    $optBuild .= '</select>';
    return $optBuild;
  }
}

function _getListName($listid='') {
  global $phpml;

  if ( trim($listid) == '' ) {
    $listid  = $_SESSION['def_list'];
  }

  $query = "SELECT title
              FROM " . $phpml['dbLists'] . "
             WHERE listid = " . $listid;
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  $row    = mysql_fetch_assoc($result);
  return $row['title'];
}

function _copyRecord($id, $id_field='msgid', $table='phpml_msgs' ) {
  global $phpml;

  // load original record into array
  $query = 'SELECT *
              FROM ' . $table . '
             WHERE ' . $id_field . ' = ' . $id . ' LIMIT 1;';
  $res   = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  $ar    = @mysql_fetch_array( $res, MYSQL_ASSOC );

  // insert new record and get new auto_increment id
  $query = 'INSERT INTO ' . $table . ' ( `' . $id_field . '` ) VALUES ( NULL );';
  mysql_query ($query) or die($PHPML_LANG["error_query"] . mysql_error());
  $id = mysql_insert_id();

  // update new record with values from previous record
  $queryu = 'UPDATE ' . $table . ' SET ';
  while ($value = current($ar)) {
    if (key($ar) != $id_field) {
      if (trim(key($ar)) == 'sent') {
        $queryu .= '`'.key($ar).'` = "0", ';
      } else {
        if (trim(key($ar)) == 'subject') {
          $queryu .= '`'.key($ar).'` = "COPY - '.$value.'", ';
        } else {
          $value = addslashes($value);
          $queryu .= '`'.key($ar).'` = "'.$value.'", ';
        }
      }
    }
    next($ar);
  }
  $queryu  = substr($queryu,0,strlen($queryu)-2).' ';
  $queryu .= 'WHERE ' . $id_field . ' = "' . $id . '" LIMIT 1;';
  mysql_query($queryu) or die($PHPML_LANG["error_query"] . mysql_error() . '<br />' . $queryu);

  // return the new id
  return $id;
}

function _format_percent($num_amount, $num_total,$sign='%') {
  if ( $num_amount == 0 || $num_total == 0 ) {
    return '0' . $sign;
  } else {
    $count1 = $num_amount / $num_total;
    $count2 = $count1 * 100;
    if (is_int($count2)) {
      $count  = number_format($count2, 0);
    } else {
      $count  = number_format($count2, 2);
    }
    return $count . $sign;
  }
}

// requires $start in format "Y-m-d"
function _getElapsedDays($start,$end='') {
  if ($end == '') {
    $end = strtotime(date("Y-m-d"));
  }
  if (!is_numeric($start)) {
    $start = strtotime($start);
  }
  return intval(($end-$start) / (60 * 60 * 24));
}

class URLcipher {
  function URLcipher() {
  }
  function encrypt($input) {
    for($i = 0; $i < strlen($input); $i++) {
      $input[$i] = ~ $input[$i];
    }
    $input = base64_encode(base64_encode($input));
    return $input;
  }
  function decrypt($input) {
    if (trim($input) == '') {
      return;
    } else {
      $input = base64_decode(base64_decode($input));
      for($i = 0; $i < strlen($input); $i++) {
        $input[$i] = ~ $input[$i];
      }
      $partsArr   = explode('&',$input);
      foreach ($partsArr as $key => $val) {
        $parts      = explode('=',$val);
        $_GET[$parts[0]] = $parts[1];
      }
    }
  }
}

?>
