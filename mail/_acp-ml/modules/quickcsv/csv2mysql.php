<?php
/*~ csv2mysql.php (QuickCSV Suite)
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
 * CSV to MySQL import
 * @package CSV2MySQL
 * @author Andy Prevost
 * @copyright 2008 - 2009 Andy Prevost. All Rights Reserved.
 */

session_start();

set_time_limit(300);

// edit upload directory
define("UPLDPATH", getcwd() . substr($_SERVER['PHP_SELF'],0,1) . 'files/');

if ( isset($_SESSION['picker']) && $_SESSION['picker'] ) {
  return;
}

$ignoreFieldsArray = array(); // insert any database field names that you want to ignore in the upload process

// do not edit below this point
require_once('../../inc.settings.php');
require_once('../../inc.settings_db.php');
require_once('../../inc.functions.php');
require_once('inc.functions.php');
require_once('inc.lang_en.php');
require_once('inc.db.php');

$iniMemory = ini_get('memory_limit');
if ($_POST['LargeMemorySupport'] == '1') {
  ini_set('memory_limit','96M');
}

$POST_MAX_SIZE = ini_get('post_max_size');
$UPLOAD_MAX_SIZE = ini_get('upload_max_size');

$mul = substr($POST_MAX_SIZE, -1);
$mul = ($mul == 'M' ? 1048576 : ($mul == 'K' ? 1024 : ($mul == 'G' ? 1073741824 : 1)));
$mul = $mul*(int)$POST_MAX_SIZE;
$mul_str = '<span style="color:red;font-size:10px;">' . $CSV_LANG['maxuploadsize'] . ': ' . number_format($mul) . ' ' . $CSV_LANG['bytes'] . ' (' . $POST_MAX_SIZE . ')</span>';

$subtitle = 'CSV2MySQL by WorxWare';

if (isset($phpml['iProtocol'])) {
  $template = _getTPL($subtitle);
  echo $template['header'];
}

echo '<div align="center">';

if ( !is_writable(UPLDPATH) ) {
  echo $CSV_LANG['errorconfig'];
  echo $template['footer'];
  ini_set('memory_limit',$iniMemory);
  exit();
}

if ( isset($_POST['tablename']) && trim($_POST['tablename']) != '' ) {
  $tablename  = $_POST['tablename'];
} else {
  $tablename  = '';
}
if ( isset($_POST['submit']) ) {
  $submit     = $_POST['submit'];
}
if ( isset($_POST['userfile']) ) {
  $userfile   = $_POST['userfile'];
}

if ( isset($_POST['headerRow']) && trim($_POST['headerRow']) == '1' ) {
  $headerRow = '1';
} else {
  $headerRow = '0';
}

if ( isset($_POST['uploadfile']) && trim($_POST['uploadfile']) != '' && $_POST['localfile'] != "ON" ) {
  $uploadfile = $_POST['uploadfile'];
}

if( isset($_FILES['userfile']['name']) && $_FILES['userfile']['name'] != '' ) {
  $filename   = $_FILES['userfile']['name'];
  $uploadfile = UPLDPATH . $_FILES['userfile']['name'];
  if ( !move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile) ) {
    echo $CSV_LANG['error_uploading_file'] . '<br />';
  }
} elseif ( isset($_POST['localfile']) && $_POST['localfile'] == "ON") {
  $uploadfile = UPLDPATH . $_POST['itemselected'];
}

if ( trim($_POST['newtablename']) != '' ) {
  $db_name = trim($_POST['newtablename']);
  $tablename = $db_name;
  // check to see if the table exists yet
  $link = mysql_connect(DBHOST, DBUSER, DBPASS);
  $db_selected = mysql_select_db($db_name, $link);
  if (!$db_selected) {
    // read the .SQL file
    $csvTableMasterFile = 'images/master.sql';
    $fd = fopen ($csvTableMasterFile, "r");
    $sql_data = fread($fd, filesize($csvTableMasterFile));
    fclose ($fd);
    $sql_data = str_replace('master_mailer',$db_name,$sql_data);
    mysql_query($sql_data, $link) or die (mysql_error());
  }
  mysql_close($link);
  require('inc.db.php'); // reload database settings
}

// select table
$tableList = _getTableList($tablename);
$table_select="<select class=\"upldborder\" name=\"tablename\">" . $tableList . "</select>";
if ( trim($tablename) == '' ) {
  echo '<form name="tableselector" method="post" action="csv2mysql.php">';
  echo '<table width="400" class="upldborder" cellpadding="3">';
  echo '  <tr>';
  echo '    <td class="upldborder"><nobr>' . $CSV_LANG['tables'] . '</nobr></td>';
  echo '    <td class="upldborder">' . $table_select . '</td>';
  echo '  </tr>';
  echo '  <tr>';
  echo '    <td class="upldborder"><nobr>' . $CSV_LANG['createtable'] . '</nobr></td>';
  echo '    <td class="upldborder"><input type="text" name="newtablename" value=""></td>';
  echo '  </tr>';
  echo '</table>';
  echo  '<input type="submit" value="' . $CSV_LANG['next'] . '">';
  echo '</form>';
  echo '<small>Copyright &copy; 2008-2009, Andy Prevost. All rights reserved.</small><br /><br />';
  echo '</div>';
  echo $template['footer'];
  ini_set('memory_limit',$iniMemory);
  exit();
} elseif ( trim($tablename) != '' ) {
  echo '<table width="685" class="upldborder" cellpadding="3">';
  echo ' <tr><td valign="top">';
  if ( (!$_FILES && !isset($uploadfile)) || isset($_POST['saveFieldMap']) ) {
    echo '<table width="400" class="upldborder" cellpadding="3">';
  } else {
    echo '<table width="400" class="upldborder" cellpadding="3">';
  }
}

// if CSV file name or upload file name is blank
if ( !$_FILES && !isset($uploadfile) ) {
  ?>
  <script language="javascript" type="text/javascript">
  function toggle_display() {
    var form   = document.getElementById('checkdisplay');
    var mydiv = document.getElementById('fileselector');
    ((form.checked)? mydiv.style.display='block': mydiv.style.display='none');
  }
  </script>
  <form name="uploadform" enctype="multipart/form-data" action="csv2mysql.php" method="post">
  <input type="hidden" name="tablename" value="<?php echo $tablename; ?>">
  <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $mul; ?>" >
  <?php
  if ( $mul > 8388608 ) {
    ?>
    <tr>
      <td class="upldborder"><nobr><?php echo $CSV_LANG['enablelargememory']; ?></nobr></td>
      <td class="upldborder"><input type="checkbox" name="LargeMemorySupport" value="1"><?php echo $CSV_LANG['enablelargememorytext']; ?></td>
    </tr>
    <?php
  }
  ?>
  <tr>
    <td colspan="2" class="upldborder" valign="top">
      <div style="padding:10px;">
      <?php echo $CSV_LANG['uploadfile']; ?>: <?php echo $mul_str; ?><br /><input name="userfile" type="file" size="50" ><br />
      <input id="checkdisplay" type="checkbox" name="localfile" value="ON" onClick="toggle_display();"> <?php echo $CSV_LANG['file_already_on_server']; ?><br />
      <div id="fileselector" style="display:none;">
      <input type="text" name="itemselected" value="" size="50"> <input type=button name=choice onClick="window.open('filepick.php','popuppage','width=500,height=200,top=100,left=100');" value=" <?php echo $CSV_LANG['select']; ?> "><br />
      <?php
      if ( $mul <= 8388608 ) {
        echo $CSV_LANG['enablelargememory'];
        ?>
        <input type="checkbox" name="LargeMemorySupport" value="1"><?php echo $CSV_LANG['enablelargememorytext']; ?>
        <?php
      }
      ?>
      </div>
      <div style="height:25px;"></div>
      <strong><?php echo $CSV_LANG['import_options']; ?>:</strong><br />
      <table cellpadding="3">
        <tr>
          <td align="right" valign="top"><?php echo $CSV_LANG['field_separator']; ?></td>
          <td>
            <input type="radio" value="automatic" name="checkSep" checked> <?php echo $CSV_LANG['automatic']; ?><br />
            <input type="radio" value="comma" name="checkSep"> <?php echo $CSV_LANG['comma']; ?><br />
            <input type="radio" value="tab" name="checkSep"> <?php echo $CSV_LANG['tab']; ?><br />
            <?php echo $CSV_LANG['or']; ?><br />
            <input type="text" name="sepchar" value=""><br />
          </td>
        </tr>
        <tr>
          <td align="right" valign="top"><?php echo $CSV_LANG['field_enclosure']; ?></td>
          <td>
            <input type="radio" value="automatic" name="checkEnc" checked> <?php echo $CSV_LANG['automatic']; ?><br />
            <input type="radio" value="double" name="checkEnc"> <?php echo $CSV_LANG['quotedouble']; ?><br />
            <input type="radio" value="single" name="checkEnc"> <?php echo $CSV_LANG['quotesingle']; ?><br />
            <input type="radio" value="none" name="checkEnc"> <?php echo $CSV_LANG['none']; ?><br />
          </td>
        </tr>
        <!--
        <tr>
          <td align="right" valign="top"><?php echo $CSV_LANG['emptycells']; ?></td>
          <td><input type="input" name="emptycells" value="NULL"> <?php echo $CSV_LANG['emptycellshelp']; ?></td>
        </tr>
        -->
  <?php
  echo '        <tr>';
  echo '          <td colspan="2"><select size="1" name="emptycells"><option selected value="NULL">NULL</option><option value="">``</option></select>&nbsp;' . $CSV_LANG['emptycellshelp'] . '</td>';
  echo '        </tr>';
  echo '        <tr>';
  echo '          <td colspan="2"><input type="checkbox" name="headerRow" value="1" checked>&nbsp;' . $CSV_LANG['CSVheader'] . '</td>';
  echo '        </tr>';
  echo '        <tr>';
  echo '          <td colspan="2"><input type="checkbox" name="allowDuplicates" value="1">&nbsp;' . $CSV_LANG['allowduplicates'] . '</td>';
  echo '        </tr>';
  echo '        <tr>';
  echo '          <td colspan="2"><input type="checkbox" name="purgeExisting" value="1" >&nbsp;' . $CSV_LANG['purgeexisting'] . '</td>';
  echo '        </tr>';
  echo '        <tr>';
  echo '          <td colspan="2"><input type="checkbox" name="deleteCSV" value="1" checked>&nbsp;' . $CSV_LANG['deletecsv'] . '</td>';
  echo '        </tr>';
  echo '        <tr>';
  echo '          <td colspan="2">' . $CSV_LANG['usefieldmap'] . ' ' . _getFieldMapList() . '</td>';
  echo '        </tr>';
  echo '        <tr>';
  echo '          <td colspan="2" align="center"><br /><input type="submit" name="submit" value="' . $CSV_LANG['go'] . '"></td>';
  echo '        </tr>';
  echo '      </table>';
  echo '      </div>';
  echo '    </td>';
  echo '    </form>';
  echo '    </tr>';
  echo '  </table>';
  echo '    </td>';
  echo '    <td width="300" valign="top">';
  $fieldmap = mysql_query("SHOW COLUMNS FROM " . $tablename);
  if (mysql_num_rows($fieldmap) > 0) {
    echo '<table width="100%" class="upldborder" cellpadding="2">';
    echo '  <tr>';
    echo '    <td class="upldborder" align="right" style="background-color:LightCyan;">' . $CSV_LANG['selectedtable'] . '</td>';
    echo '    <td class="upldborder" style="background-color:LightCyan;"><strong>' . trim($tablename) . '</strong></td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <td class="upldborder" align="right" style="background-color:LightGoldenRodYellow;">' . $CSV_LANG['field'] . '</td>';
    echo '    <td class="upldborder" style="background-color:LightGoldenRodYellow;">' . $CSV_LANG['type'] . '</td>';
    echo '  </tr>';
    while ($row = mysql_fetch_assoc($fieldmap)) {
      echo '  <tr>';
      echo '    <td class="upldborder" align="right">' . $row['Field'] . '</td>';
      echo '    <td class="upldborder">' . $row['Type'] . '</td>';
      echo '  </tr>';
    }
    echo "</table>";
  }
  echo '    </td>';
  echo '    </tr>';
  echo '  </table>';
  echo '  <small>Copyright &copy; 2008-2009, Andy Prevost. All rights reserved.</small><br /><br />';
}

$tfields = mysql_list_fields(DBNAME,$tablename);
$columns = mysql_num_fields($tfields);
for ( $i = 0; $i < $columns; $i++ ) {
  if ( !in_array(mysql_field_name($tfields,$i),$ignoreFieldsArray) ) {
    $fieldsArr[] = mysql_field_name($tfields,$i);
  }
}

if ( isset($submit) && $submit == $CSV_LANG['go'] ) {

  if ( $_POST['purgeExisting'] == '1' ) { // means purge the existing records from the table
    $query = 'DELETE FROM ' . $tablename;
    $result = mysql_query($query);
  }

  // Field Separator Definition
  if ( isset($_POST['sepchar']) && trim($_POST['sepchar']) != '' ) {
    $csv_file['sepa'] = $_POST['sepchar'];
  } else {
    if ( isset($_POST['checkSep']) ) {
      if ($_POST['checkSep'] == 'automatic') {
        $csv_file['sepa'] = '';
      } elseif ($_POST['checkSep'] == 'comma') {
        $csv_file['sepa'] = ",";
      } elseif ($_POST['checkSep'] == 'tab') {
        $csv_file['sepa'] = "\t";
      }
    } else {
      $csv_file['sepa'] = ",";
    }
  }

  // Field Enclosure Character used in CSV file
  if ( trim($_POST['checkEnc']) != '' && $_SESSION['encchar'] == '' ) {
    $_SESSION['encchar'] = $_POST['checkEnc'];
  }

  if ( $_SESSION['encchar'] == '' ) {
    $csv_file['sepatxt'] = "'";
  } elseif ( $_SESSION['encchar'] == 'automatic' ) {
    $csv_file['sepatxt'] = '';
  } elseif ( $_SESSION['encchar'] == 'single' ) {
    $csv_file['sepatxt'] = "'";
  } elseif ( $_SESSION['encchar'] == 'double' ) {
    $csv_file['sepatxt'] = '"';
  } elseif ( $_SESSION['encchar'] == 'none' ) {
    $csv_file['sepatxt'] = '';
  }

  // BUILD THE FIELD MAP DISPLAY
  $file_contents_line = null;
  $file_contents_line = @file($uploadfile, FILE_IGNORE_NEW_LINES) or die ($uploadfile . ' ' . $CSV_LANG['error_not_found']);

  // check for automatic field separator - can only be tab or comma
  if ( $csv_file['sepa'] == '' ) {
    if ( stristr($file_contents_line[0], "\t") ) {
      $csv_file['sepa'] = "\t";
    } else {
      $csv_file['sepa'] = ",";
    }
  }

  if ( $_SESSION['encchar'] == 'automatic' ) {
    $file_contents_line[0] = parse_csv_line($file_contents_line[0]);
  }
  $values = explode($csv_file['sepa'], $file_contents_line[0]);
  if ( $_POST['field'][0] == '' ) {
    // retrieve field map array from file
    if ( $_POST['selectFieldMapFile'] != 'none' ) {
      $tableArr = unserialize(file_get_contents('fieldmaps/'.$_POST['selectFieldMapFile'].'.php'));
    }
    for ($v = 0; $v < count($values); $v++) {
      $currValue = trim($values[$v]);
      echo '  <tr>';
      echo '    <td class="upldborder" colspan="2">';
      echo $CSV_LANG['need_to_map'] . '<br />';
      echo '<form name="fieldmap" method="post" action="csv2mysql.php">';
      echo '<input type="hidden" name="tablename" value="' . $tablename . '">';
      echo '<input type="hidden" name="uploadfile" value="' . $uploadfile . '">';
      echo '<input type="hidden" name="headerRow" value="' . $headerRow . '">';
      echo '<input type="hidden" name="mapproc" value="1">';
      echo '<input type="hidden" name="checkEnc" value="' . $_SESSION['encchar'] . '">';
      echo '<input type="hidden" name="deleteCSV" value="' . $_POST['deleteCSV'] . '">';
      echo '<input type="hidden" name="allowDuplicates" value="' . $_POST['allowDuplicates'] . '">';
      echo '<input type="hidden" name="emptycells" value="' . $_POST['emptycells'] . '">';
      echo '<input type="hidden" name="LargeMemorySupport" value="' . $_POST['LargeMemorySupport'] . '">';
      echo '<table cellpadding="3" style="border-collapse:collapse;">';
      for ($f = 0; $f < count($values); $f++) {
        $values[$f] = trim($values[$f]);
        if ( $_SESSION['encchar'] == 'automatic' ) {
          if ( (substr($values[$f],0,1) == '"' && substr($values[$f],-1) == '"') || (substr($values[$f],0,1) == "'" && substr($values[$f],-1) == "'") ) {
            $valuesDisplay[$f] = substr($values[$f],1,-1);
          } else {
            $valuesDisplay[$f] = $values[$f];
          }
        } elseif ( $_SESSION['encchar'] == 'single' ) {
          $valuesDisplay[$f] = str_replace("'",'',$values[$f]);
        } elseif ( $_SESSION['encchar'] == 'double' ) {
          $valuesDisplay[$f] = str_replace('"','',$values[$f]);
        } else {
          $valuesDisplay[$f] = $values[$f];
        }
        $valuesDisplay[$f] = trim($valuesDisplay[$f]);
        $p1  = '<select class="upldborder" name="field[' . $f . ']">';
        $p2  = '<select class="upldborder" name="dupFieldCheck">';
        $p3  = '<select class="upldborder" name="emailvalidfield">';
        $p3 .= '<option value="" selected>no</option>';
        $p1 .= '<option value="none">none</option>';
        for ( $p = 0; $p < count($fieldsArr); $p++ ) {
          if ( !in_array($fieldsArr[$p],$ignoreFieldsArray) ) {
            if ( (is_array($tableArr) && $tableArr[$valuesDisplay[$f]] != '') &&
                 ( trim($tableArr[$valuesDisplay[$f]]) == trim($fieldsArr[$p]) )
               ) {
              $p1 .= '<option selected value="' . $tableArr[$valuesDisplay[$f]] . '">' . $tableArr[$valuesDisplay[$f]] . '</option>';
            } elseif ( $fieldsArr[$p] == trim($values[$f]) ) {
              $p1 .= '<option selected value="' . $fieldsArr[$p] . '">' . $fieldsArr[$p] . '</option>';
            } else {
              $p1 .= '<option value="' . $fieldsArr[$p] . '">' . $fieldsArr[$p] . '</option>';
            }
          }
          if ( trim($valuesDisplay[$p]) != '' ) {
            $p2 .= '<option value="' . $p . '|' . $valuesDisplay[$p] . '"';
            $p3 .= '<option value="' . $p . '|' . $valuesDisplay[$p] . '"';
          }
          if ( trim(strtolower($fieldsArr[$p])) == 'email' ) {
            $p2 .= ' selected';
          }
          $p2 .= '>' . $valuesDisplay[$p] . '</option>';
          $p3 .= '>' . $valuesDisplay[$p] . '</option>';
        }
        $p1 .= '</select>';
        $p2 .= '</select>';
        $p3 .= '</select>';
        echo '<tr>';
        echo '<td class="upldborder" align="right"><input type="hidden" name="fieldcsv[' . $f . ']" value="' . $valuesDisplay[$f] . '">' . $valuesDisplay[$f] . '</td><td class="upldborder"> &rArr; </td><td class="upldborder">' . $p1 . '</td>';
        echo '</tr>';
      }
      echo '<tr>';
      echo '<td colspan="3" align="center"><input type="checkbox" name="saveFieldMap" value="1">&nbsp;' . $CSV_LANG['savefieldmap'] . ' - Name: <input type="text" name="fieldMapName" value="' . $tablename . '" size="35"></td>';
      echo '</tr>';
      if ( $_POST['allowDuplicates'] != '1' ) { // means duplicates are not allowed
        echo '<tr>';
        echo '<td colspan="3" align="center">' . $CSV_LANG['duplicatescheckfield'] . ' ' . $p2 . '</td>';
        echo '</tr>';
      }
      echo '<tr>';
      echo '<td colspan="3" align="center">' . $CSV_LANG['validateemailfield'] . ' ' . $p3 . '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td colspan="3" align="center"><input name="submit" type="submit" value="' . $CSV_LANG['go'] . '"></td>';
      echo '</tr>';
      echo '</form>';
      echo '</table>';
      echo '    </td>';
      echo '  </tr>';
      echo '</table><br /><small>' . $CSV_LANG['noextension'] . '</small><br />';
      echo '    </td>';
      echo '    <td width="300" valign="top">';
      $fieldmap = mysql_query("SHOW COLUMNS FROM " . $tablename);
      if (mysql_num_rows($fieldmap) > 0) {
        echo '<table width="100%" class="upldborder" cellpadding="2">';
        echo '  <tr>';
        echo '    <td class="upldborder" align="right" style="background-color:LightCyan;">' . $CSV_LANG['selectedtable'] . '</td>';
        echo '    <td class="upldborder" style="background-color:LightCyan;"><strong>' . trim($tablename) . '</strong></td>';
        echo '  </tr>';
        echo '  <tr>';
        echo '    <td class="upldborder" align="right" style="background-color:LightGoldenRodYellow;">' . $CSV_LANG['field'] . '</td>';
        echo '    <td class="upldborder" style="background-color:LightGoldenRodYellow;">' . $CSV_LANG['type'] . '</td>';
        echo '  </tr>';
        while ($row = mysql_fetch_assoc($fieldmap)) {
          echo '  <tr>';
          echo '    <td class="upldborder" align="right">' . $row['Field'] . '</td>';
          echo '    <td class="upldborder">' . $row['Type'] . '</td>';
          echo '  </tr>';
        }
        echo "</table>";
      }
      echo '    </td>';
      echo '    </tr>';
      echo '  </table>';
      echo '<small>Copyright &copy; 2008-2009, Andy Prevost. All rights reserved.</small><br /><br />';
      $v = count($values);
      echo $template['footer'];
      ini_set('memory_limit',$iniMemory);
      exit();
    }
  }

  // PROCESS THE FIELD MAP DISPLAY
  if ( $_POST['saveFieldMap'] == 1 ) {
    // build the field map
    for ($i=0; $i<count($_POST['field']); $i++) {
      $saveArr[trim($_POST['fieldcsv'][$i])] = $_POST['field'][$i];
    }
    // save field map array to file
    $fp = fopen('fieldmaps/' . $_POST['fieldMapName'] . '.php', 'w');
    fwrite($fp, serialize($saveArr));
    fclose($fp);
  }

  $file_contents_line = null;
  $file_contents_line = @file($uploadfile, FILE_IGNORE_NEW_LINES) or die ($uploadfile . ' ' . $CSV_LANG['error_not_found']);

  $fin = $file_contents_line[0];
  $values = explode($csv_file['sepa'], $fin );
  $headInsert .= "(`";
  $headCount = 0;
  for ($j = 0; $j < count($values); $j++) {
    if ( $_POST['field'][$j] != 'none' ) {
      $values[$j] = $_POST['field'][$j];
      $headInsert .= addslashes(utf8_decode(trim(str_replace("'","",$values[$j]),"[\r\t\n\v\' ]" ))).(($j != (count($values)-1)) ? "`,`" : "");
      $headCount++;
    }
  }
  if ( substr($headInsert,-3) == '`,`' ) { $headInsert = substr($headInsert,0,-3); }
  $headInsert .= "`)";
  $field1       = 0;
  $recCount     = 0;
  $arrCount     = 0;
  $valArr       = array();
  $dupCount     = 0;
  $invalidCount = 0;
  $insCount     = 0;
  foreach ($file_contents_line as $key => $val) {
    set_time_limit(30);
    $field1++; //skip field names or first line
    if ( $_POST['mapproc'] != '1' ) {
      if ( empty($val) || ( $_POST['headerRow'] == '1' && $field1 == '1') ) { // Skip empty lines
        continue;
      }
    }
    if ( ($headerRow != '1' && $field1 == 1) || ($field1 > 1) ) {
      // check for duplicates here
      $goaheadAndPost = true;
      // run tests on data (duplicates, email validation)
      $test_line = parse_csv_line($val);
      $prevalues = explode(',', $test_line);
      $dupArr = explode('|',$_POST['dupFieldCheck']);
      $dupField_db  = $_POST['field'][$dupArr[0]];
      $dupField_csv = $_POST['fieldcsv'][$dupArr[0]];
      $dupText_csv  = $prevalues[$dupArr[0]];
      // validate email
      if ( $_POST['emailvalidfield'] != '' ) {
        if (!_validEmail($prevalues[$dupArr[0]])) {
          $goaheadAndPost = false;
          $invalidCount++;
        }
      }
      // check for duplicates
      if ( $_POST['allowDuplicates'] != '1' ) { // means duplicates are not allowed
        $sql = "SELECT * FROM " . $tablename . " WHERE " . $dupField_db . " = '" . $prevalues[$dupArr[0]] . "'";
        $num_rows = 0;
        $result = mysql_query($sql);
        if ( $result ) {
          $num_rows = mysql_num_rows($result);
          if ( $num_rows != 0 || in_array($val, $valArr) ) {
            $goaheadAndPost = false;
            $dupCount++;
          }
        }
        $valArr[] = $val;
      }

    }
    // END run tests on data (duplicates, email validation)
    if ( $_SESSION['encchar'] == 'automatic' ) {
      $val = parse_csv_line($val);
    }
    $resetvalues = explode($csv_file['sepa'], $val);
    for ($q = 0; $q < count($resetvalues); $q++) {
      $resetvalues[$q] = trim($resetvalues[$q]);
      if ( $_POST['field'][$q] != 'none' ) {
        $newVal[] = $resetvalues[$q];
      }
    }
    if ( $newVal ) {
      $val = implode(",", $newVal);
    }
    unset($newVal);

    if ( $goaheadAndPost !== false ) {
      if ( ($headerRow != '1' && $field1 == 1) || ($field1 > 1) ) {
        if ( $headerRow != '1' ) {
          $dataInsert .= ( ($key >= 1) ? ", " : "" ) . "(";
        } else {
          $dataInsert .= ( ($key >= 2) ? ", " : "" ) . "(";
        }
        $val1 = $val;
        $values = explode($csv_file['sepa'], $val1);
        $dataCount = 0;
        for ($j = 0; $j <= ($headCount - 1); $j++) {
          $values[$j] = str_replace(",","&#44;",$values[$j]);
          $values[$j] = str_replace("\\'","\\\'",$values[$j]); // replace single quotes
          if ( trim($values[$j]) == '' ) {
            if ( trim($_POST['emptycells']) == '' ) {
              $dataInsert .= ",";
            } else {
              $dataInsert .= $_POST['emptycells'] . ",";
            }
          } else {
            $dataInsert .= "`" . addslashes(utf8_decode(trim(str_replace("~","`,`",$values[$j]),"[\r\t\n\v\' ]")))."`,"; //.(($j != (count($values) - 1)) ? "," : "");
          }
          $val=$val1="";
          $dataCount++;
        }
        if ( substr($dataInsert,0,1) == ',' ) { $dataInsert = substr($dataInsert,1); }
        if ( substr($dataInsert,-1) == ',' ) { $dataInsert = substr($dataInsert,0,-1); }
        $dataInsert .= ");";
        $dataInsert  = str_replace("`","'",$dataInsert);
        $dataInsert  = str_replace('\\"',"",$dataInsert);
        _postCSVline($tablename, $headInsert, $dataInsert);
        $dataInsert = '';
        $insCount++;
      }
    }
    $recCount++;
  }
  echo '<tr><td colspan="2" style="padding:10px;"><span style="font-weight:bold;font-size:14px;">' . $CSV_LANG['CSVuploadcomplete'] . " - " . $insCount . " " . $CSV_LANG['CSVuploadrecords'];
  if ( $_POST['allowDuplicates'] != '1' ) { // means duplicates are allowed
    echo '<br />&nbsp;&ndash;&nbsp;' . $CSV_LANG['duplicatesfound'] . ': ' . $dupCount;
  }
  if ( $invalidCount > 0 ) {
    echo '<br />&nbsp;&ndash;&nbsp;' . $CSV_LANG['invalidemailcount'] . ': ' . $invalidCount;
  }
  echo '</span></td></tr>';
  echo '</table>';
  echo '    </td>';
  echo '    </tr>';
  echo '  </table>';
  echo '<br />';
  echo '<small>Copyright &copy; 2008-2009, Andy Prevost. All rights reserved.</small><br /><br /><br /><br />';
  if ( $_POST['deleteCSV'] ) {
    unlink($uploadfile);
  }
}
?>
</div>
<?php
echo '</div>';
echo $template['footer'];
ini_set('memory_limit',$iniMemory);
exit();

function parse_csv_line($str, $options = null) {
  if ( stristr($str, "\t") ) {
    $delimiter = empty($options['delimiter']) ? "\t" : $options['delimiter'];
  } else {
    $delimiter = empty($options['delimiter']) ? "," : $options['delimiter'];
  }
  $realCount = substr_count($str, '"') / 2;
  if ( $realCount > 0 ) {
    for ($i=1;$i<=$realCount;$i++) {
      if (strstr($str, '"')) {
        $start_pos = strpos($str,'"');
        $next_pos  = strpos($str,'"',$start_pos+1);
        $strCheck  = substr($str,$start_pos,$next_pos);
        if (strstr($strCheck, $delimiter)) {
          $delim_pos = strpos($str,',',$start_pos+1);
          $str = substr_replace($str, '&#044;',$delim_pos,1);
        }
      }
    }
  }
  $expr="/$delimiter(?=(?:[^\"]*\"[^\"]*\")*(?![^\"]*\"))/";
  $del_sep = '';
  $field_names = explode($delimiter, $str);
  $fields = preg_split($expr,trim($str));
  $fields = preg_replace("/^\"(.*)\"$/s","$1",$fields);
  $_res = array();
  foreach ($field_names as $key => $f) {
    $f = trim($f);
    $fields[$key] = trim($fields[$key]);
    if ( (substr($f,0,1) == substr($f,-1) ) && (!ereg("^[a-zA-Z0-9]$",substr($f,0,1)) && !ereg("^[a-zA-Z0-9]$",substr($f,-1))) && substr($f,0,1) != '"' && substr($f,-1) != '"' ) {
      $fields[$key] = substr($fields[$key],1,-1);
    }
    $_res[$f] = $fields[$key];
    if ( strstr($_res[$f],$delimiter) ) {
      $_res[$f] = str_replace($delimiter,'&#'.ord($delimiter).';',$_res[$f]);
    }
    $del_sep .= $delimiter . $_res[$f];
  }
  $del_sep = substr($del_sep,1);
  if ( substr($del_sep,-1) == $delimiter ) {
    $del_sep = substr($del_sep,-1);
  }
  return $del_sep;
}

function _postCSVline($tablename, $headInsert, $dataInsert) {
  $sql = "INSERT INTO `" . $tablename . "` " . $headInsert . " VALUES ".$dataInsert;
  if ( $dataInsert != " ;" ) {
    $res = mysql_query($sql) or die(mysql_error() . '<br />' . $sql);
  }
}

function _validEmail($email) {
  $regexp = "^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$";
  // Validate the syntax
  if (eregi($regexp, $email)) {
    return true;
  }
  return false;
}

?>