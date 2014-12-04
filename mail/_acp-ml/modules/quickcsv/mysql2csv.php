<?php
/*~ mysql2csv.php (QuickCSV Suite)
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

require_once('../../inc.settings.php');
require_once('../../inc.settings_db.php');
require_once('../../inc.functions.php');
require_once('inc.functions.php');
require_once('inc.lang_en.php');
require_once('inc.db.php');

$filename_export = 'csv_export_' . date('Y-m-d') . '.csv'; // same date format as MySQL

$subtitle = 'MySQL2CSV by WorxWare';

$template = _getTPL($subtitle);

echo $template['header'];

echo '<div align="center">';

if ( !is_writable(UPLDPATH) ) {
  echo $CSV_LANG['errorconfig'];
  exit();
}

echo '<table width="400" class="upldborder" cellpadding="3">';
//echo '<tr><td colspan="2" align="center" style="background-color:#0080C0;color:white;font-weight:bold;font-size:18px;font-family:georgia,times roman,serif;">MySQL2CSV<br /><i>by WorxWare</i><br /><span style="font-size:11px;">www.worxware.com</span></td></tr>';

if ( $_POST['submit'] == $CSV_LANG['select'] ) {
  $tablename = $_POST['tablename'];
  $query = "SHOW COLUMNS FROM {$tablename}";
  if ( $result=mysql_query($query) ) {
    /* Store the column names retrieved in an array */
    $column_names = array();
    $num = 0;
    $field_select .= '<table width="100%" class="upldborder" cellpadding="1">';
    $field_select .= '<tr>';
    //$field_select .= '<td class="upldborder" align="center">Field</td>';
    $field_select .= '<td class="upldborder" align="center" valign="bottom">' . $CSV_LANG['select'] . '</td>';
    $field_select .= '<td class="upldborder" align="center" valign="bottom">' . $CSV_LANG['distinct'] . '</td>';
    $field_select .= '<td class="upldborder" align="center" valign="bottom">' . $CSV_LANG['notempty'] . '</td>';
    $field_select .= '<td class="upldborder" align="center" valign="bottom">' . $CSV_LANG['caseupper'] . '</td>';
    $field_select .= '<td class="upldborder" align="center" valign="bottom">' . $CSV_LANG['caselower'] . '</td>';
    $field_select .= '<td class="upldborder" align="center" valign="bottom">' . $CSV_LANG['conversion'] . '</td>';
    $field_select .= '</tr>';

    while ($row = mysql_fetch_array($result)) {
      $field_select .= '<tr>';
      $field_select .= '<td class="upldborder"><nobr><input type="checkbox" name="frmColumnNames[]" value="' . $num . '">' . $row['Field'] . '</nobr><input type="hidden" name="frmColumnText[]" value="' . $num . '|' . $row['Field'] . '"></td>';
      $field_select .= '<td class="upldborder" align="center"><input type="radio" name="frmDistinct[]" value="' . $row['Field'] . '"></td>';
      $field_select .= '<td class="upldborder" align="center"><input type="checkbox" name="frmNotEmpty[]" value="' . $row['Field'] . '"></td>';
      $field_select .= '<td class="upldborder" align="center"><input type="checkbox" name="frmUCase[]" value="' . $row['Field'] . '"></td>';
      $field_select .= '<td class="upldborder" align="center"><input type="checkbox" name="frmLCase[]" value="' . $row['Field'] . '"></td>';
      $field_select .= '<td class="upldborder" align="center"><input type="text" name="frmConversion[]" value=""></td>';
      $field_select .= '</tr>';
      $num++;
    }
    $field_select .= '</table>';
  }
  echo '  <tr><form name="tableselector" method="post" action="mysql2csv.php">';
  echo '    <td class="upldborder" valign="top"><nobr>' . $CSV_LANG['fields'] . '</nobr></td>';
  echo '    <td class="upldborder" valign="top">';
  echo $field_select;
  echo '<input name="tablename" type="hidden" value="'.$tablename.'">';
  echo '<input name="submit" type="submit" value="' . $CSV_LANG['next'] . '">';
  echo '</td>';
  echo '</tr></form>';
} elseif ( $_POST['submit'] == 'Next >>>' ) {
  $tablename    = $_POST['tablename'];
  $col_names = '';
  $col_distinct = '';
  $col_notempty = '';
  $col_ucase    = '';
  $col_lcase    = '';
  $col_case     = '';
  $col_nums     = '';
  foreach ($_POST['frmColumnNames'] as $value) {
    $col_nums .= $value . ',';
  }
  if ( trim($col_nums) != '' ) {
    $col_nums = substr($col_nums,0,-1);
  }
  $keepCount = 0;
  foreach ($_POST['frmColumnText'] as $key => $value) {
    $splitLine = explode('|',$value);
    if ( in_array($splitLine[0],$_POST['frmColumnNames']) ) {
      $col_names .= $splitLine[1] . '|';
      if ( isset($_POST['frmDistinct']) && in_array($splitLine[1],$_POST['frmDistinct']) ) {
        $col_distinct .= '1|';
      } else {
        $col_distinct .= '|';
      }
      if ( isset($_POST['frmNotEmpty']) && in_array($splitLine[1],$_POST['frmNotEmpty']) ) {
        $col_notempty .= '1|';
      } else {
        $col_notempty .= '|';
      }
      if ( isset($_POST['frmUCase']) && in_array($splitLine[1],$_POST['frmUCase']) ) {
        $col_ucase .= '1|';
      } else {
        $col_ucase .= '|';
      }
      if ( isset($_POST['frmLCase']) && in_array($splitLine[1],$_POST['frmLCase']) ) {
        $col_lcase .= '1|';
      } else {
        $col_lcase .= '|';
      }
      if ( isset($_POST['frmConversion']) && trim($_POST['frmConversion'][$key]) != '' ) {
        $col_case .= $_POST['frmConversion'][$key] . '|';
      } else {
        $col_case .= '|';
      }
    }
    $keepCount++;
  }
  $col_names = substr($col_names,0,-1);
  $col_distinct = substr($col_distinct,0,-1);
  $col_notempty = substr($col_notempty,0,-1);
  echo '<form name="export" action="export_csv.php" method="post">';
  echo '<input name="tablename" type="hidden" value="'.$tablename.'">';
  echo '<input name="cols" type="hidden" value="'.$col_nums.'">';
  echo '<input name="frmColumnNames" type="hidden" value="'.$col_names.'">';
  echo '<input name="frmDistinct" type="hidden" value="'.$col_distinct.'">';
  echo '<input name="frmNotEmpty" type="hidden" value="'.$col_notempty.'">';
  echo '<input name="frmUCase" type="hidden" value="'.$col_ucase.'">';
  echo '<input name="frmLCase" type="hidden" value="'.$col_lcase.'">';
  echo '<input name="frmConversion" type="hidden" value="'.$col_case.'">';
  echo '  <tr>';
  echo '    <td class="upldborder" valign="top" align="right"><nobr>' . $CSV_LANG['field_separator'] . '</nobr></td>';
  echo '    <td class="upldborder" valign="top">';
  echo '      <input type="radio" value="comma" name="checkSep" checked> ' . $CSV_LANG['comma'] . '<br />';
  echo '      <input type="radio" value="tab" name="checkSep"> ' . $CSV_LANG['tab'] . '<br />';
  echo '    </td>';
  echo '  </tr>';
  echo '  <tr>';
  echo '    <td class="upldborder" valign="top" align="right"><nobr>' . $CSV_LANG['field_enclosure'] . '</nobr></td>';
  echo '    <td class="upldborder" valign="top">';
  echo '      <input type="radio" value="enc_automatic" name="checkEnc" checked> ' . $CSV_LANG['automatic'] . '<br />';
  echo '      <input type="radio" value="enc_double" name="checkEnc"> ' . $CSV_LANG['quotedouble'] . '<br />';
  echo '      <input type="radio" value="enc_single" name="checkEnc"> ' . $CSV_LANG['quotesingle'] . '<br />';
  echo '      <input type="radio" value="enc_none" name="checkEnc"> ' . $CSV_LANG['none'] . '<br />';
  echo '    </td>';
  echo '  </tr>';
  echo '  <tr>';
  echo '    <td class="upldborder" valign="top" align="right"><nobr>' . $CSV_LANG['filename'] . '</nobr></td>';
  echo '    <td class="upldborder" valign="top">';
  echo '      <input type="text" value="' . $filename_export . '" name="filename" style="width:99%;">';
  echo '    </td>';
  echo '  </tr>';
  echo '  <tr>';
  echo '    <td class="upldborder" valign="top" align="right"><nobr>' . $CSV_LANG['querypreprocess'] . '</nobr></td>';
  echo '    <td class="upldborder" valign="top">';
  echo '      <textarea rows="4" name="frmQuery_pre" style="width:99%"></textarea>';
  echo '    </td>';
  echo '  </tr>';
  echo '  <tr>';
  echo '    <td class="upldborder" valign="top" align="right"><nobr>' . $CSV_LANG['queryprocess'] . '</nobr></td>';
  echo '    <td class="upldborder" valign="top">';
  echo '      <textarea rows="4" name="frmQuery" style="width:99%"></textarea>';
  echo '    </td>';
  echo '  </tr>';
  echo '  <tr>';
  echo '    <td class="upldborder" valign="top" align="right">&nbsp;</td>';
  echo '    <td class="upldborder" valign="top">';
  echo '      <input type="checkbox" value="1" name="purge"> ' . $CSV_LANG['purgeafterprocess'];
  echo '    </td>';
  echo '  </tr>';
  echo '  <tr>';
  echo '    <td class="upldborder" valign="top" align="right">&nbsp;</td>';
  echo '    <td class="upldborder" valign="top">';
  echo '      <input type="checkbox" value="1" name="replacenull"> ' . $CSV_LANG['replacenull'];
  echo '    </td>';
  echo '  </tr>';
  echo '  <tr>';
  echo '    <td class="upldborder" valign="top" align="right">&nbsp;</td>';
  echo '    <td class="upldborder" valign="top">';
  echo '      <input name="submit" type="submit" value="' . $CSV_LANG['export'] . '">';
  echo '    </td>';
  echo '  </tr>';
  echo '</form></td>';
  echo '</tr>';
  $start_over = true;
} else {
  $tableList = _getTableList($tablename,false);
  $table_select="<select class=\"upldborder\" name=\"tablename\">" . $tableList . "</select>";
  if ( trim($tablename) == '' ) {
    echo '  <tr><form name="tableselector" method="post" action="mysql2csv.php">';
    echo '    <td class="upldborder"><nobr>' . $CSV_LANG['tables'] . '</nobr></td>';
    echo '    <td class="upldborder">' . $table_select . '&nbsp;<input name="submit" type="submit" value="' . $CSV_LANG['select'] . '">';
    echo '</td>';
    echo '</tr></form>';
  }
}
echo '</table>';
echo '<small>Copyright &copy; 2008-2009, Andy Prevost. All rights reserved.</small><br /><br />';
echo '</div>';
echo $template['footer'];
exit();
?>
