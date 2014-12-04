<?php
/*~ export_csv.php (QuickCSV Suite)
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

/**
 * MySQL To CSV export
 * @package MySQL2CSV
 * @author Andy Prevost
 * @copyright 2008 - 2009 Andy Prevost. All Rights Reserved.
 */

session_start();

set_time_limit(3000);

// edit upload directory
define("UPLDPATH", getcwd() . substr($_SERVER['PHP_SELF'],0,1) . 'files/');

require_once('inc.functions.php');
require_once('inc.lang_en.php');
require_once('inc.db.php');

// User submitted (through the form) Pre-Process Query
if ( isset($_POST['frmQuery_pre']) ) {
  $keywrd  = array('INSERT','UPDATE','REPLACE','DELETE');
  $keywArr = explode(' ',strtoupper($_POST['frmQuery_pre']));
  $sql = stripslashes($_POST['frmQuery_pre']);
  $result = mysql_query($sql);
}

// Field Separator
if ( trim($_POST['checkSep']) ) {
  if ( $_POST['checkSep'] == 'comma' ) {
    $delimiter = ",";
  } elseif ( $_POST['checkSep'] == 'tab' ) {
    $delimiter = "\t";
  }
} else {
  $delimiter = ",";
}

// Field Enclosure
if ( trim($_POST['checkEnc']) ) {
  if ( $_POST['checkEnc'] == 'enc_automatic' ) {
    $field_enclosure = '';
  } elseif ( $_POST['checkEnc'] == 'enc_double' ) {
    $field_enclosure = '"';
  } elseif ( $_POST['checkEnc'] == 'enc_single' ) {
    $field_enclosure = "'";
  } elseif ( $_POST['checkEnc'] == 'enc_none' ) {
    $field_enclosure = '';
  }
} else {
  $field_enclosure = '"';
}

//filename for exported file
if ( trim($_POST['filename']) ) {
  $filename = trim($_POST['filename']);
} else {
  $filename = 'csv_export_' . date('Y-m-d') . '.csv'; // same date format as MySQL
}

//Send headers
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");

if( trim($_POST["tablename"]) != '' ) {
  $query  = "SHOW COLUMNS FROM " . $_POST['tablename'];
  $result = mysql_query($query);
  $thiscount = 0;
  $col_nums = explode(',',$_POST["cols"]);
  $line = '';
  while ($row = mysql_fetch_array($result)) {
    if (in_array($thiscount, $col_nums)) {
      $line .= str_replace("\r\n", " ", $row[0]) . $delimiter;
    }
    $thiscount++;
  }
  $line = substr($line, 0, -1);
  echo $line . "\r\n";
}

if ( trim($_POST['frmQuery']) != '' ) {
  $query = stripslashes(trim($_POST['frmQuery']));
} else {
  $col_names    = explode('|',$_POST['frmColumnNames']);
  $col_distinct = explode('|',$_POST['frmDistinct']);
  $col_notempty = explode('|',$_POST['frmNotEmpty']);
  $col_ucase    = explode('|',$_POST['frmUCase']);
  $col_lcase    = explode('|',$_POST['frmLCase']);
  $col_case     = explode('|',$_POST['frmConversion']);

  $where        = '';
  $thisCount    = count($col_names);
  $fieldList    = '';
  $distinctTrue = false;
  for ($i = 0; $i < count($col_names); $i++) {
    if ( trim($col_distinct[$i]) != '' && !$distinctTrue ) {
      $fieldList  = 'DISTINCT `' . $col_names[$i] . '`,' . $fieldList;
      $distinctTrue = true;
    } else {
      $fieldList .= '`' . $col_names[$i] . '`,';
    }
  }
  $fieldList = substr($fieldList,0,-1);
  $query = "SELECT " . $fieldList;

  for ($i = 0; $i < count($col_names); $i++) {
    if ( trim($col_notempty[$i]) != '' ) {
      if ( $where == '' ) {
        $where    = ' WHERE `' . $col_names[$i] . "` != '';";
      } else {
        $where    = substr($where, 0, -1);
        $where   .= ' AND `' . $col_names[$i] . "` != '';";
      }
    }
  }
  $query  .= " FROM `" . $_POST['tablename'] . '`' . $where;
}
$result = mysql_query( $query );
while ($row = mysql_fetch_assoc($result)) {
  $line = '';
  for ($i = 0; $i < count($col_names); $i++) {
    $fieldValue = $row[$col_names[$i]];
    if ( $_POST['replacenull'] ) {
      $fieldValue = str_replace('NULL','',$fieldValue);
    }
    if ( $col_ucase[$i] ) {
      $fieldValue = strtoupper($fieldValue);
    } elseif ( $col_lcase[$i] ) {
      $fieldValue = strtolower($fieldValue);
    } elseif ( trim($col_case[$i]) != '' ) {
      $col_case[$i] = str_replace('(','',$col_case[$i]);
      $col_case[$i] = str_replace(')','',$col_case[$i]);
      $fieldValue = $col_case[$i]($fieldValue);
    }
    if ( $_POST['checkEnc'] == 'enc_automatic' && strstr($fieldValue, $delimiter) ) {
      $line .= '"' . str_replace("\r\n", " ", $fieldValue) . '"' . $delimiter;
    } else {
      $line .= $field_enclosure . str_replace("\r\n", " ", $fieldValue) . $field_enclosure . $delimiter;
    }
  }
  $line = substr($line, 0, -1);
  echo $line . "\r\n";
}

if ( $_POST['purge'] ) {
  $query = "DELETE FROM " . $_POST['tablename'];
  $result = mysql_query( $query );
}

?>
