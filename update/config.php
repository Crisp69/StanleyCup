<?php
########################################################################
# Edit-Point 4.00 Beta - Simple Content Management System
# Copyright (c)2005-2007 Todd Strattman
# strattman@gmail.com
# http://covertheweb.com/edit-point/
# License: LGPL
########################################################################

// INITIAL SETTINGS //
include ($_SERVER['DOCUMENT_ROOT'] ."/stanleycup/settings.php");

// Language to use. (English = en.php :: Duetsch = de.php :: Espanol = es.php :: Nederlands = nl.php)
$language = "en.php";


// PASSWORD PROTECTION SETTINGS //

// I STRONGLY recommend using the built in password protection. I believe it is much more secure than .htaccess or most other password protection scripts. Options.php must be used for the password protection. The passwords cannot be set using the config.php file. Cookies must be enabled.
$password_protect = "on";

// FILE UPLOAD //
// Option to use basic file upload/delete.

// Whether or not the fileupload option is available. on or off.
$fileupload = "off";
// The choice to use either ftp or php to upload files. Use "ftp" or "php".
$upload_process = "php";
// Name of the directory that files are added to. This will be created automatically one directory above the "text" directory. For instance, your Edit-Point installation is: http://YOURDOMAIN.com/text/ and the file upload directory (files) will be: http://YOURDOMAIN.com/files/
$dir = $_GET['page'];
if (!IsSet($dir)) {$dir ="schedule";}

$fileupload_dir_name = "stanleycup/data/".$dir;
// FTP username. This is ONLY NEEDED IF FTP WAS CHOSEN for the upload method.
$ftp_user = "ftp_username";
// FTP password. This is ONLY NEEDED IF FTP WAS CHOSEN for the upload method.
$ftp_pass = "ftp_password";
// Path from default ftp login directory to file upload directory. This is ONLY NEEDED IF FTP WAS CHOSEN for the upload method.
$ftp_path = "public_html";
$head = "on";

// BASIC SETTINGS //

// Redirect speed after editing a point (index.php). 1000 = 1 second
$edit_redirect = "2000";

// Redirect speed after creating a point (admin.php). 1000 = 1 second
$admin_redirect = "2000";

// Textarea width (rows).
$edit_width = "60";

// Textarea height (columns)
$edit_height = "18";


// Data directory name (where the .txt files, created by the script, are stored). Do not change unless you manually change the "data" directory name.
$datadir = "data";

// Path from script directory to webpage directory. Do not change unless you have moved the script directory from the default (http://YOURDOMAIN.COM/text).
$pagepath = "../";

// Html start tag. The following are only used for Edit-Point script pages.
$p = "<p>";
// Html end tag
$p2 = "</p>";

?>