<?php
/*~ inc.db.php (QuickCSV Suite)
.---------------------------------------------------------------------------.
|  Software: QuickCSV Suite (CSV To MySQL and MySQL To CSV                  |
|   Version: 1.0                                                            |
|      Info: http://www.worxware.com                                        |
| ------------------------------------------------------------------------- |
|     Owner: Worx International Inc., Andy Prevost                          |
|    Author: Andy Prevost (andy.prevost@worxteam.com)                       |
| Copyright (c) 2008-2009, Andy Prevost. All Rights Reserved.               |
| ------------------------------------------------------------------------- |
|   License: Attribution-Noncommercial-No Derivative Works 3.0 Unported     |
|                                                                           |
|            You are allowed:                                               |
|            - to Share: to copy, distribute and transmit the work          |
|                                                                           |
|            Under the following conditions:                                |
|            Attribution - You must attribute the work in the manner        |
|              specified by the author or licensor (but not in any way that |
|              suggests that they endorse you or your use of the work).     |
|            Noncommercial - You may not use this work for commercial       |
|              purposes.                                                    |
|            No Derivative Works - You may not alter, transform, or build   |
|              upon this work.                                              |
|                                                                           |
|            With the understanding that:                                   |
|            Waiver - Any of the above conditions can be waived if you get  |
|              permission from the copyright holder.                        |
|            Other Rights - In no way are any of the following rights       |
|              affected by the license:                                     |
|              * Your fair dealing or fair use rights;                      |
|              * The author's moral rights;                                 |
|              * Rights other persons may have either in the work itself or |
|                in how the work is used, such as publicity or privacy      |
|                rights.                                                    |
|                                                                           |
|            For more information on this license type:                     |
|            http://creativecommons.org/licenses/by-nc-nd/3.0/              |
|                                                                           |
|            IF YOU WISH TO USE 'QuickCSV Suite'  IN A COMMERCIAL OR        |
|            REVENUE-GENERATING PROJECT OR WEBSITE, PLEASE CONTACT US FOR A |
|            COMMERCIAL LICENSE.                                            |
|                                                                           |
| This program is distributed in the hope that it will be useful - WITHOUT  |
| ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     |
| FITNESS FOR A PARTICULAR PURPOSE.                                         |
| ------------------------------------------------------------------------- |
| We offer a number of paid services (www.worxware.com):                    |
| - Web Hosting on highly optimized fast and secure servers                 |
| - Technology Consulting                                                   |
| - Oursourcing (highly qualified programmers and graphic designers)        |
'---------------------------------------------------------------------------'
Last updated: July 15 2009
*/

/**
 * CSV to MySQL import
 * MySQL to CSV import
 * @package CSV2MySQL
 * @package MySQL2CSV
 * @author Andy Prevost
 * @copyright 2008 - 2009 Andy Prevost. All Rights Reserved.
 */

if (!defined('DBNAME')) {
  define('DBHOST', 'localhost');
  define('DBNAME', ''); // database name
  define('DBUSER', ''); // database username
  define('DBPASS', ''); // database password
}

/* do not edit anything below here */
defined('_WRX') or die( _errorMsg('Restricted access') );
defined('DBPASS') or die( _errorMsg('Database settings missing ... cannot proceed.') );
$conn1 = mysql_connect(DBHOST, DBUSER, DBPASS);
if ( !$conn1 ) {
  die('Could not connect: ' . mysql_error());
}
$db1   = mysql_select_db(DBNAME, $conn1);
if ( !$db1 ) {
  die('Unable to select database' . mysql_error());
}
/* check writable state of files and folders */
$errorstate = false;
$error      = _isWritableFolder('files');
if ( $error ) { $errorstate = true; }
$error      = _isWritableFolder('fieldmaps');
if ( $error ) { $errorstate = true; }
if ( $errorstate ) {
  die();
}

/* FUNCTIONS ******************************/

if (!function_exists('_getTableCount')) {
  function _getTableCount($table) {
    $query = "SELECT count(*) AS num
                FROM `" . $table . "`";
    $result = mysql_db_query(DBNAME,$query);
    $mycount = mysql_result($result,0,'num');
    return $mycount;
  }
}

if (!function_exists('_getTableList')) {
  function _getTableList($tablename='',$tblcreate=true) {
    $tableList = '';
    $result = mysql_list_tables(DBNAME);
    while ($row = mysql_fetch_array($result)) {
      if( trim($tablename) != '' && $row[0] == $tablename ) {
        $tableList .= "<option selected value=".$row[0].">".$row[0]."</option>";
      } else {
        $tableList .= "<option value=".$row[0].">".$row[0]."</option>";
      }
    }
    if ( trim($tableList) == '' && $tblcreate !== false ) { // table list is blank, use SQL
      $sql = file_get_contents('images/vcard.sql');
      mysql_query($sql) or die(mysql_error());
      $tableList = _getTableList($tablename);
    }
    return $tableList;
  }
}
?>