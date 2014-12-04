<?php
/*~ _acp-ml/inc.settings.php
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

/* CONFIGURATION SETTINGS (note: trailing slashes on all paths and URLs) */

if ( !$_SESSION ) {
  session_start();
}

/* GENERAL & PATH SETTINGS */

$phpml['FromAddy']       = 'you@yourdomain.com'; // Your email address
$phpml['FromName']       = 'Firstname Lastname'; // Your Full Name

// NOTE: You should not have to edit anything below here. If you do, make sure you know what you are doing.
$phpml['iProtocol']      = "http://"; // option is "https://";
$phpml['path_base']      = getBasePath(); // PHPMailer-ML (Mailing List) root path
$phpml['path_root']      = $_SERVER['DOCUMENT_ROOT'] . '/' . $phpml['path_base'];
$phpml['path_admin']     = $phpml['path_root'] . '/' . $_SESSION['acp'];
$phpml['modules']        = 'modules';
$phpml['url_root']       = $phpml['iProtocol']  . $_SERVER["HTTP_HOST"] . '/' . $phpml['path_base'];
$phpml['url_admin']      = $phpml['url_root'] . '/' . $_SESSION['acp'];
$phpml['PHPMailer_path'] = $phpml['path_admin'] . '/' . $phpml['modules'] . '/phpmailer'; // Path to PHPMailer class
$phpml['LangPref']       = 'en';
$phpml['ListName']       = 'PHPMailer-ML';
$phpml['ReturnPage']     = "index.php";    // default return page if HTTP_REFERER not found
$phpml['useBcc']         = false;
$phpml['EmailSend']      = true;
$phpml['adminBcc']       = true;
$phpml['trackOpens']     = true; //false; // tracks the opening of emails
$phpml['progressmin']    = 25;
if ( file_exists($phpml['modules'] . '/spaw2/spaw.inc.php') ) {
  $phpml['editor']         = 'spaw2';
  $phpml['userdir']    = $phpml['path_root'] . '/_msgimgs';
  $phpml['userURL']    = $phpml['url_root'] . '/_msgimgs';
  $phpml['editorincl'] = $phpml['modules'] . '/spaw2/spaw.inc.php';
} elseif ( file_exists($phpml['modules'] . '/ckeditor/ckeditor.js') ) {
  $phpml['editor']         = 'ckeditor';
  $phpml['userdir']        = $phpml['path_root'] . '/_msgimgs';
  $phpml['userURL']        = $phpml['url_root'] . '/_msgimgs';
  $phpml['editorinit']     = '<script type="text/javascript" src="' . $phpml['modules'] . '/ckeditor/ckeditor.js"></script>' . "\n";
  if ( file_exists($phpml['modules'] . '/kfm/configuration.php') ) {
    $phpml['filemgr']        = 'kfm';
    $phpml['kfmpath']        = $phpml['modules'] . '/kfm/';
  } else {
    $phpml['filemgr']        = 'none';
  }
} else {
  $phpml['userdir']    = $phpml['path_root'] . '/_msgimgs';
  $phpml['userURL']    = $phpml['url_root'] . '/_msgimgs';
  $phpml['editor']         = 'none';
}
define('_WRX', 1);
define('IS_WINDOWS', (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'));

/* check writable state of files and folders */
$errormsg = '';
if ( $phpml['editor'] == 'spaw2' && !is_writable($phpml['path_admin'] . '/'  . $phpml['modules'] . '/spaw2/uploads/images') ) {
  $errormsg .= 'Sorry, problem with configuration ... <br />';
  $errormsg .= 'uploads directory is not writable (for image uploads)<br />';
  $errormsg .= '(' . $phpml['path_admin'] . '/spaw2/uploads/)<br />';
  $errormsg .= 'Please correct and try again.<br /><br />';
}
if ( ($phpml['editor'] == 'ckeditor' || $phpml['editor'] == 'none') && !is_writable($phpml['path_admin'] . '/user_imgs') ) {
  $errormsg .= 'Sorry, problem with configuration ... <br />';
  $errormsg .= 'uploads directory is not writable (for image uploads)<br />';
  $errormsg .= '(' . $phpml['path_admin'] . '/user_imgs/)<br />';
  $errormsg .= 'Please correct and try again.<br /><br />';
}
if ( file_exists($phpml['modules'] . '/quickcsv/inc.db.php') ) {
  if ( !is_writable($phpml['modules'] . '/quickcsv/fieldmaps') ) {
    $errormsg .= 'Sorry, problem with configuration ... <br />';
    $errormsg .= 'QuickCSV Suite "fieldmaps" directory is not writable<br />';
    $errormsg .= '(' . $phpml['modules'] . '/quickcsv/fieldmaps)<br />';
    $errormsg .= 'Please correct and try again.<br /><br />';
  }
}
if ( file_exists($phpml['modules'] . '/quickcsv/inc.db.php') ) {
  if ( !is_writable($phpml['modules'] . '/quickcsv/files') ) {
    $errormsg .= 'Sorry, problem with configuration ... <br />';
    $errormsg .= 'QuickCSV Suite "files" directory is not writable<br />';
    $errormsg .= '(' . $phpml['modules'] . '/quickcsv/files)<br />';
    $errormsg .= 'Please correct and try again.<br /><br />';
  }
}
if ( !is_writable($phpml['path_root'] . '/_msgimgs') ) {
  $errormsg .= 'Sorry, problem with configuration ... <br />';
  $errormsg .= 'The message images directory is not writable<br />';
  $errormsg .= '(' . $phpml['path_root'] . '/_msgimgs)<br />';
  $errormsg .= 'Please correct and try again.<br /><br />';
}
if ( IS_WINDOWS ) {
  if ( !is_writable($phpml['path_admin'] . '/inc.settings.php') ) {
    $errormsg .= 'Sorry, problem with settings file ... <br />';
    $errormsg .= 'settings file is not writable (for updating application settings)<br />';
    $errormsg .= '(' . $phpml['path_admin'] . '/inc.settings.php)<br />';
    $errormsg .= 'Please correct and try again.<br />';
  }
  if ( !is_writable($phpml['path_admin'] . '/inc.settings_smtp.php') ) {
    $errormsg .= 'Sorry, problem with settings file ... <br />';
    $errormsg .= 'settings file is not writable (for updating smtp settings)<br />';
    $errormsg .= '(' . $phpml['path_admin'] . '/inc.settings_smtp.php)<br />';
    $errormsg .= 'Please correct and try again.<br />';
  }
  if ( !is_writable($phpml['path_admin'] . '/.htpasswd') ) {
    $errormsg .= 'Sorry, problem with settings file ... <br />';
    $errormsg .= 'password file is not writable (for adding and updating users)<br />';
    $errormsg .= '(' . $phpml['path_admin'] . '/.htpasswd)<br />';
    $errormsg .= 'Please correct and try again.<br />';
  }
  if ( file_exists($phpml['modules'] . '/quickcsv/inc.db.php') ) {
    if ( !is_writable($phpml['modules'] . '/quickcsv/inc.db.php') ) {
      $errormsg .= 'Sorry, problem with settings file ... <br />';
      $errormsg .= 'QuickCSV database settings file is not writable<br />';
      $errormsg .= '(' . $phpml['modules'] . '/quickcsv/inc.db.php)<br />';
      $errormsg .= 'Please correct and try again.<br />';
    }
  }
} else {
  if ( substr(sprintf('%o', fileperms($phpml['path_admin'] . '/inc.settings.php')), -4) < '0664' ) {
    $errormsg .= 'Sorry, problem with settings file ... <br />';
    $errormsg .= 'settings file is not writable (for updating application settings)<br />';
    $errormsg .= '(' . $phpml['path_admin'] . '/inc.settings.php)<br />';
    $errormsg .= 'Please correct and try again.<br />';
  }
  if ( substr(sprintf('%o', fileperms($phpml['path_admin'] . '/inc.settings_smtp.php')), -4) < '0664' ) {
    $errormsg .= 'Sorry, problem with settings file ... <br />';
    $errormsg .= 'settings file is not writable (for updating smtp settings)<br />';
    $errormsg .= '(' . $phpml['path_admin'] . '/inc.settings_smtp.php)<br />';
    $errormsg .= 'Please correct and try again.<br />';
  }
  if ( substr(sprintf('%o', fileperms($phpml['path_admin'] . '/.htpasswd')), -4) < '0664' ) {
    $errormsg .= 'Sorry, problem with settings file ... <br />';
    $errormsg .= 'password file is not writable (for adding and updating users)<br />';
    $errormsg .= '(' . $phpml['path_admin'] . '/.htpasswd)<br />';
    $errormsg .= 'Please correct and try again.<br />';
  }
  if ( file_exists($phpml['modules'] . '/quickcsv/inc.db.php') ) {
    if ( substr(sprintf('%o', fileperms($phpml['modules'] . '/quickcsv/inc.db.php')), -4) < '0664' ) {
      $errormsg .= 'Sorry, problem with settings file ... <br />';
      $errormsg .= 'QuickCSV database settings file is not writable<br />';
      $errormsg .= '(' . $phpml['modules'] . '/quickcsv/inc.db.php)<br />';
      $errormsg .= 'Please correct and try again.<br />';
    }
  }
}

if ( $errormsg != '' ) {
  $errormsg = '<div style="font-size:18px;font-weight:bold;color:red;text-align:center;font-family:sans-serif;">' . $errormsg;
  $errormsg .= '</div>';
  echo $errormsg;
  exit();
}

/* include other config and settings */
require_once($phpml['path_root'] . '/_acp-ml/inc.settings_smtp.php');
require_once($phpml['path_root'] . '/_acp-ml/inc.settings_db.php');
require_once($phpml['path_root'] . '/' . $_SESSION['acp'] . '/language/phpml.lang-' . $phpml['LangPref'] . '.php');

/* FUNCTION */

function getBasePath() {
  $pathSelf    = dirname($_SERVER['PHP_SELF']);
  $pos         = strpos($pathSelf,'_acp');
  if ($pos) {
    $pathSelf = substr($pathSelf,0,$pos);
  }
  if (substr($pathSelf,0,1) == '/') {
    $pathSelf = substr($pathSelf,1);
  }
  if (substr($pathSelf,-1) == '/') {
    $pathSelf = substr($pathSelf,0,-1);
  }
  return $pathSelf;
}
if (!function_exists('_errorMsg')) {
  function _errorMsg($errormsg) {
    $error  = '<div style="font-size:18px;font-weight:bold;color:red;text-align:center;font-family:sans-serif;">';
    $error .= $errormsg;
    $error .= '</div>';
    echo $error;
    die();
  }
}
?>
