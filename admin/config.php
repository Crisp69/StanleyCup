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
// Files to ignore(not list) in the upload directory. ".htaccess" is ignored by default.
if ($dir == "schedule") {
$up_ignore = "schedule".$current_season.".txt";
$up_ignore2 = "playoff".$current_season.".txt"; $up_ignore1 = "tabs".($current_season+12).".rar";$up_ignore3 = "tabs".($current_season+12).".zip";
}
if ($dir == "standings") {
$up_ignore = "standings".$current_season.".txt";}

if ($dir == "stats") {
$up_ignore = "points".$current_season."reg.txt";$up_ignore1 = "goals".$current_season."reg.txt";$up_ignore2 = "defs".$current_season."reg.txt";$up_ignore3 = "goalies".$current_season."reg.txt"; $up_ignore6 = "points".$current_season."po.txt";$up_ignore7 = "goals".$current_season."po.txt";$up_ignore8 = "defs".$current_season."po.txt";$up_ignore9 = "goalies".$current_season."po.txt"; $up_ignore5 = "SC_stats_".($current_season+12).".rar"; $up_ignore4 = "SC_stats_".($current_season+12)."_po.rar"; $up_ignore10 = "SC_stats_".($current_season+12)."_po.zip";$up_ignore11 = "SC_stats_".($current_season+12).".zip";$up_ignore12 = "stars".$current_season."reg.txt";}

if ($dir == "data") {
$up_ignore = "news.txt";}

if ($dir == "stars") {
$up_ignore = "star".$current_season.".txt";}

if ($dir == "reg") {
$up_ignore = "reg_old.txt";}

if ($dir == "magazine") {
$up_ignore = "magazine.txt";}

if ($dir == "magazine/comments") {
$up_ignore = "16.txt";}


?>