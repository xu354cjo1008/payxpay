<?php
/*~ getimg.php
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

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

require_once('_acp-ml/inc.settings.php');

if ($phpml['trackOpens']) {
  require_once('_acp-ml/inc.functions.php');
  $eid    = $_GET['eid'];
  $mid    = $_GET['mid'];
  $img    = $_GET['img'];
  $ip     = $_SERVER['REMOTE_ADDR'];
  $query  = "INSERT INTO " . $phpml['dbTrack'] . "
               (`eid`,`mid`,`ipaddr`,`atime`)
             VALUES ('" . $eid . "','" . $mid . "','" . $ip . "',now())";
  $result = mysql_query($query);
}

header("Location: " . $phpml['url_admin'] . "/appimgs/spacer.gif");
return;

?>