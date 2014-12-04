<?php
/*~ filepick.php (QuickCSV Suite)
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
?>
<HEAD>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function sendValue(s) {
  var selvalue = s.options[s.selectedIndex].value;
  window.opener.document.uploadform.itemselected.value = selvalue;
  window.close();
}
//  End -->
</script>
</HEAD>
<BODY>
<center>
<form name="selectform">
<select name="selectmenu" size="8" style="width:450px;">
<?php
session_start();
$_SESSION['picker'] = true;
include_once('csv2mysql.php');
$dir = UPLDPATH;
$_SESSION['picker'] = false;
// Edit me ^^ ! //
if ($handle = opendir($dir)) {
  while (false !== ($file = readdir($handle))) {
    if (fnmatch("*.php", $file)) {
      echo '';
    } elseif (fnmatch(".*", $file)) {
      echo '';
    } else {
      echo '<option value="' . $file . '">' . $file . '</option>';
    }
  }
  closedir($handle);
}
?>
</select>
<p>
<input type=button value="Item Select Item" onClick="sendValue(this.form.selectmenu);">
</form>
</center>