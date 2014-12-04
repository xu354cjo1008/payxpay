<?php
/*~ inc.lang_en.php (QuickCSV Suite)
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

$CSV_LANG['affectedrows']             = 'affected rows';
$CSV_LANG['allowduplicates']          = 'Allow Duplicates?';
$CSV_LANG['automatic']                = 'Automatic';
$CSV_LANG['bytes']                    = 'bytes';
$CSV_LANG['caseupper']                = 'U Case';
$CSV_LANG['caselower']                = 'L Case';
$CSV_LANG['comma']                    = 'Comma';
$CSV_LANG['continue']                 = 'Continue';
$CSV_LANG['conversion']               = 'Conv';
$CSV_LANG['createtable']              = 'Create New';
$CSV_LANG['CSVheader']                = 'CSV file contains header row';
$CSV_LANG['CSVuploadcomplete']        = 'CSV upload complete';
$CSV_LANG['CSVuploadrecords']         = 'records posted';
$CSV_LANG['databases']                = 'Databases';
$CSV_LANG['deletecsv']                = 'Delete CSV after processing?';
$CSV_LANG['distinct']                 = 'Distinct';
$CSV_LANG['duplicatescheckfield']     = 'Duplicates Field Check';
$CSV_LANG['duplicatesfound']          = 'duplicates found';
$CSV_LANG['emptycells']               = 'Empty cells value';
$CSV_LANG['emptycellshelp']           = '<small>leave blank, if desired</small>';
$CSV_LANG['enablelargememory']        = 'Enable Large File Support?';
$CSV_LANG['enablelargememorytext']    = ' <small>for files greater than 8 Mb</small>';
$CSV_LANG['error_not_found']          = 'not found error';
$CSV_LANG['error_query']              = 'MySQL Error';
$CSV_LANG['error_uploading_file']     = 'Error uploading file';
$CSV_LANG['export']                   = 'Export';
$CSV_LANG['field']                    = 'Field';
$CSV_LANG['field_enclosure']          = 'Field Enclosure';
$CSV_LANG['field_separator']          = 'Field Separator';
$CSV_LANG['fields']                   = 'Fields';
$CSV_LANG['file_already_on_server']   = 'No upload, file already on server';
$CSV_LANG['file_not_writable']        = 'The file is not writable, nothing to do!';
$CSV_LANG['filename']                 = 'Filename';
$CSV_LANG['go']                       = 'Go';
$CSV_LANG['import']                   = 'Import CSV';
$CSV_LANG['import_options']           = 'Import File Options';
$CSV_LANG['invalidemailcount']        = 'invalid emails';
$CSV_LANG['launchmysql2csv']          = 'Launch MySQL2CSV';
$CSV_LANG['launchcsv2mysql']          = 'Launch CSV2MySQL';
$CSV_LANG['mailinglist']              = 'Mailing List';
$CSV_LANG['maxuploadsize']            = 'Max upload size';
$CSV_LANG['need_to_map']              = 'Need to map CSV Row 1 field names to database field names';
$CSV_LANG['next']                     = 'Next >>>';
$CSV_LANG['noextension']              = 'Note: Field map name must not contain any extensions.';
$CSV_LANG['none']                     = 'None';
$CSV_LANG['notempty']                 = 'Not empty';
$CSV_LANG['or']                       = 'or';
$CSV_LANG['purgeafterprocess']        = 'Purge Table After Exporting CSV?';
$CSV_LANG['purgeexisting']            = 'Purge Existing Records?';
$CSV_LANG['querypreprocess']          = 'Query (PreProcess)';
$CSV_LANG['queryprocess']             = 'Query (Process)';
$CSV_LANG['quotedouble']              = 'Double Quote';
$CSV_LANG['quotesingle']              = 'Single Quote';
$CSV_LANG['records']                  = 'records';
$CSV_LANG['replacenull']              = 'Replace NULL with space?';
$CSV_LANG['savefieldmap']             = 'Save Field Map';
$CSV_LANG['select']                   = 'Select';
$CSV_LANG['selectedtable']            = 'Selected Table';
$CSV_LANG['startover']                = 'Start Over';
$CSV_LANG['tab']                      = 'Tab';
$CSV_LANG['table']                    = 'Table';
$CSV_LANG['tables']                   = 'Tables';
$CSV_LANG['to']                       = 'To';
$CSV_LANG['type']                     = 'Type';
$CSV_LANG['uploadfile']               = 'Upload File';
$CSV_LANG['usefieldmap']              = 'Use Field Map';
$CSV_LANG['validateemailfield']       = 'Validate Email?';

// do not edit below this point

$CSV_LANG['errorconfig']  = '<div style="font-size:18px;font-weight:bold;color:red;text-align:center;font-family:sans-serif;">';
$CSV_LANG['errorconfig'] .= 'Sorry, problem with configuration ... <br />';
$CSV_LANG['errorconfig'] .= 'CSV uploads directory is not writable<br />';
$CSV_LANG['errorconfig'] .= '(' . UPLDPATH . ')<br />';
$CSV_LANG['errorconfig'] .= 'Please correct and try again.<br /><br />';
$CSV_LANG['errorconfig'] .= '</div>';

define('_WRX', 1);

?>
