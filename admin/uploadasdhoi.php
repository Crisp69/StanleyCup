<?php
########################################################################
# Edit-Point 4.00 Beta - Simple Content Management System
# Copyright (c)2005-2008 Todd Strattman
# strattman@gmail.com
# http://covertheweb.com/edit-point/
# License: LGPL
########################################################################
// Config.php is the main configuration file.
include('config.php');
// Password file.
if (is_file("$datadir/upload_pass.php")) {
include ("$datadir/upload_pass.php");
}
// Language file.
include("lang/$language");
// Name of page for links, title, and logout.
$logout = "upload.php";
if ($su == "on") {
	$page_name = "su";
} else {
	$page_name = "upload";
}
// Password protection.
// Random string generator.
function randomstring($length){
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	$string  = $chars{ rand(0,62) };
	for($i=1;$i<$length;$i++){
		$string .= $chars{ rand(0,62) };
	}
	return $string;
}
if ($password_protect == "on") {
	session_start();
	if(!empty($_POST['pass_hash_upload'])) {
		// Crypt, hash, and store password in session.
		$_SESSION['pass_hash_upload'] = crypt(md5($_POST['pass_hash_upload']), md5($_POST['pass_hash_upload']));
		// Crypt random string with random string seed for agent response.
		$string_agent = crypt($_SESSION['random'], $_SESSION['random']);
		// Hash crypted random string for random string response.
		$string_string = md5($string_agent);
		// Hash and concatenate md5/crypted random string and password hash posts.
		$string_response = md5($string_string . $_POST['pass_hash2']);
		// Concatenate agent and language.
		$agent_lang = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');
		// Hash crypted agent/language concatenate with random string seed for check against post.
		$agent_response = md5(crypt(md5($agent_lang), $string_agent));
	// Check crypted pass against stored pass. Check random string and pass hashed concatenate against post. Check hashed and crypted agent/language concatenate against post.
	} if (($_SESSION['pass_hash_upload'] != $upload_password) || ($_POST['pass_string_hash'] != $string_response) || ($_POST['agenthash'] != $agent_response)) {
		// Otherwise, give login.

		// Set random string session.
		$_SESSION['random'] = randomstring(40);
		// Crypt random string with random string seed.
		$rand_string = crypt($_SESSION['random'], $_SESSION['random']);
		// Concatenate agent and language.
		$agent_lang = getenv('HTTP_USER_AGENT').getenv('HTTP_ACCEPT_LANGUAGE');
		// Crypt agent and language with random string seed for form submission.
		$agent = crypt(md5($agent_lang), $rand_string);
		// Form md5 and encrypt javascript.
		echo "$p
		<b>$l_global13</b>
		$p2
		<script language=\"JavaScript\" type=\"text/javascript\" src=\"jscripts/crypt/sha256.js\"></script>
		<script language=\"JavaScript\" type=\"text/javascript\" src=\"jscripts/crypt/md5.js\"></script>
		<script language=\"JavaScript\" type=\"text/javascript\">
		function obfuscate() {
			document.form1.pass_hash_upload.value = hex_sha256(document.form1.pass_upload.value);
			document.form1.pass_hash2.value = hex_md5(document.form1.pass_upload.value);
			document.form1.string_hash.value = hex_md5(document.form1.string.value);
			document.form1.pass_string_hash.value =  hex_md5(document.form1.string_hash.value  + document.form1.pass_hash2.value);
			document.form1.agenthash.value = hex_md5(document.form1.agent.value);
			document.form1.pass_upload.value = \"\";
			document.form1.string.value = \"\";
			document.form1.agent.value = \"\";
			document.form1.jscript.value = \"on\";
			return true;
		}
		</script>
		<form action=\"upload.php\" method=\"post\" name=\"form1\" onsubmit=\"return obfuscate()\">
		$p
		<input name=\"jscript\" type=\"hidden\" value=\"off\" />
		<input name=\"pass_hash_upload\" type=\"hidden\" value=\"\" />
		<input name=\"pass_hash2\" type=\"hidden\" value=\"\" />
		<input name=\"string_hash\" type=\"hidden\" value=\"\" />
		<input name=\"pass_string_hash\" type=\"hidden\" value=\"\" />
		<input name=\"agenthash\" type=\"hidden\" value=\"\" />
		<input name=\"string\" type=\"hidden\" value=\"$rand_string\" />
		<input name=\"agent\" type=\"hidden\" value=\"$agent\" />
		<input type=\"password\" name=\"pass_upload\" />
		<input type=\"submit\" value=\"$l_global14\" />
		$p2
		</form>";
		exit();
	}
} else {
}
// End password protection.

function upload1() {
// Config.php is the main configuration file.
include('config.php');
// Language file.
include("lang/$language");
// Name of page for links, title, and logout.
$logout = "upload.php";
if ($su == "on") {
	$page_name = "su";
} else {
	$page_name = "upload";
}


// Upload file form.
if ($upload_process == "php") {
	echo "
	<h1>Stanley Cup web update - $dir</h1><p>
	<table width=\"95%\" align=\"center\"><tr><td>
	<select class=\"list\" onchange=\"document.location.href=value;\"><option value=\"\">&nbsp;choose session...</option>
	<option value=\"upload.php?page=standings\">&nbsp;standings </option>
	<option value=\"upload.php?page=schedule\">&nbsp;schedule </option>
	<option value=\"upload.php?page=stats\">&nbsp;stats </option>
	<option value=\"upload.php?page=data\">&nbsp;news </option>
	</td></tr></table>
	<br><table align=\"center\" width=\"95%\" class=\"table\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
	<tr>
	<td colspan=\"6\">
	<form action=\"upload.php?page=$dir\" class=\"date\" method=\"post\" enctype=\"multipart/form-data\">
	<div id =\"uploadpopup\">
	<input type=\"hidden\" name=\"cmd\" value=\"upload2\" />&nbsp;<input type=\"file\" class=\"date\" name=\"ftp_file\" />
	<br /><br />
	<input type=\"submit\" class=\"date\" name=\"submit\" value=\"$l_upload1\" />
	<br /><br />
	</div>
	</form>
	</td>
	</tr>
	</table>
	<table align=\"center\" width=\"95%\" class=\"table\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
	<tr>
	<td width=\"20%\" class=\"uploadlistname\">$p<b>$l_upload3</b>$p2</td>
	<td width=\"10%\" class=\"uploadlistsize\">$p<b>$l_upload4</b>$p2</td>
	<td width=\"20%\" class=\"uploadlistmod\">$p<b>$l_upload5</b>$p2</td>
	<td width=\"50%\" class=\"uploadlistloc\">$p<b>$l_upload8</b>$p2</td>
	</tr>";
}
// Path from Edit-Point directory to upload directory
$upload_dir = ($_SERVER['DOCUMENT_ROOT'] . "/stanleycup/$fileupload_dir_name");

// Create upload directory if it doesn't exist.
if (!is_dir($upload_dir)) {
	if (!mkdir($upload_dir))
	die ("$l_upload11");
	if (!chmod($upload_dir,0755))
	die ("$l_upload12");
}
echo "http://".$_SERVER['HTTP_HOST']."/$fileupload_dir_name";
if (is_empty_dir($upload_dir) == true) {
	echo "</table>";
} elseif (is_empty_dir($upload_dir) == false) {
// List files in the upload directory.
$dir_handle = opendir($upload_dir);
if ($dir_handle) {
	while (false !==($file = readdir($dir_handle))) {
		$upload_files = "$upload_dir/$file";
		if ((is_file($upload_files)) && ($file!=".htaccess") && (($file ==$up_ignore) || ($file ==$up_ignore1) || ($file ==$up_ignore2) || ($file ==$up_ignore3) || ($file ==$up_ignore4))) {
			$upload_name_sort[] = $file;
			
		}
	}
sort($upload_name_sort);
foreach ($upload_name_sort as $file) echo "
<tr>
<td class=\"uploadlistname\">$file</td>
<td class=\"uploadlistsize\">".upload_file_size("$upload_dir/$file")."</td>
<td class=\"uploadlistmod\">".date("d M Y - H:i", filemtime("$upload_dir/$file"))."</td>
<td class=\"uploadlistloc\"><a href=\"http://".$_SERVER['HTTP_HOST']."/$fileupload_dir_name/$file\">http://".$_SERVER['HTTP_HOST']."/$fileupload_dir_name/$file</a></td>
</tr>";
}
closedir($dir_handle);
echo "</table>";

}

// Include footer if "on" in config.php.
if ($head == "on") {
	include("footer.php");
}
}

// Upload file function.
function upload2($ftp_file, $upload_type) {
// Config.php is the main configuration file.
include('config.php');
// Language file.
include("lang/$language");
// Name of page for links, title, and logout.
$logout = "upload.php";
if ($su == "on") {
	$page_name = "su";
} else {
	$page_name = "upload";
}


// Php upload process.
if ($upload_process == "php") {
	// Path from domain name to upload directory
	$upload_dir = ($_SERVER['HTTP_HOST']."/$fileupload_dir_name/");
	$target_path = $upload_dir_name . basename( $_FILES['ftp_file']['name']);
	if (move_uploaded_file($_FILES['ftp_file']['tmp_name'], $target_path)) {
		chmod($upload_dir . basename( $_FILES['ftp_file']['name']), 0644);
		echo $p."$l_upload13 ".  basename( $_FILES['ftp_file']['name']). "$p2";
	} else {
		echo $p."$l_upload14 ".  basename( $_FILES['ftp_file']['name']). "$p2";
	}
	// Redirect to upload page.
	if ($su == "on") {
		$upload_redirect = $admin_redirect;
	} else {
		$upload_redirect = $edit_redirect;
	}
	echo "<script type=\"text/javascript\">
	<!--
	var URL   = \"upload.php?page=$dir\"
	var speed = $upload_redirect
	function reload() {
	location = URL
	}
	setTimeout(\"reload()\", speed);
	//-->
	</script>
	$p
	$l_upload15
	$p2";
// Ftp upload process.
} else {
	// Connect to the ftp address.
	$connect = ftp_connect($_SERVER['HTTP_HOST']);
	// Login to ftp address.
	ftp_login($connect, $ftp_user, $ftp_pass);
	// The path and filename to be uploaded.
	$filename = "$ftp_path/$fileupload_dir_name/" . $_FILES['ftp_file']['name'];
	// The file to be uploaded.
	$file = $_FILES['ftp_file']['name'];
	// The local file be uploaded.
	$local_file = $_FILES['ftp_file']['tmp_name'];
	// Upload file as binary or ascii.
	if ($upload_type == "binary") {
		// Upload file as binary.
		if (ftp_put($connect, $filename, $local_file, FTP_BINARY)) {
			echo $p."$l_upload13 <b>$file</b>$p2";
		} else {
			echo $p."$l_upload14 <b>$file</b>$p2";
		}
	} elseif ($upload_type == "ascii") {
		// Upload file as ascii.
		if (ftp_put($connect, $filename, $local_file, FTP_ASCII)) {
			echo $p."$l_upload13 <b>$file</b>$p2";
		} else {
			echo $p."$l_upload14 <b>$file</b>$p2";
		}
	} elseif ($upload_type == "") {
		echo $p."<b>$l_upload16</b>
		<br />
		$l_upload17 ";
	}
	
	// Redirect to upload page.
	if ($su == "on") {
		$upload_redirect = $admin_redirect;
	} else {
		$upload_redirect = $edit_redirect;
	}
	echo "<script type=\"text/javascript\">
	<!--
	var URL   = \"upload.php\"
	var speed = $upload_redirect
	function reload() {
	location = URL
	}
	setTimeout(\"reload()\", speed);
	//-->
	</script>
	/$p
	$l_upload15
	$p2";
}

// Include footer if "on" in config.php.
if ($head == "on") {
	include("footer.php");
}
}

// Function to delete files.
function upload_delete($file) {
// Config.php is the main configuration file.
include('config.php');
// Language file.
include("lang/$language");
// Name of page for links, title, and logout.
$logout = "upload.php";
if ($su == "on") {
	$page_name = "su";
} else {
	$page_name = "upload";
}
// Include header if "on" in config.php.
if ($head == "on") {
	include("header.php");
}

// Path to file.
$upload_file_path = ($_SERVER['DOCUMENT_ROOT'] . "/$fileupload_dir_name/$file");
// Delete file
unlink($upload_file_path);
echo "$p<b>$file</b> $l_upload18$p2";

// Redirect to upload page.
if ($su == "on") {
	$upload_redirect = $admin_redirect;
} else {
	$upload_redirect = $edit_redirect;
}
echo "<script type=\"text/javascript\">
<!--
var URL   = \"upload.php\"
var speed = $upload_redirect
function reload() {
location = URL
}
setTimeout(\"reload()\", speed);
//-->
</script>
$p
$l_upload15
$p2";

// Include footer if "on" in config.php.
if ($head == "on") {
	include("footer.php");
}
}

// Function to rename file.
function upload_rename($file, $upload_newname) {
// Config.php is the main configuration file.
include('config.php');
// Language file.
include("lang/$language");
// Name of page for links, title, and logout.
$logout = "upload.php";
if ($su == "on") {
	$page_name = "su";
} else {
	$page_name = "upload";
}
// Include header if "on" in config.php.
if ($head == "on") {
	include("header.php");
}

// Path to file.
$upload_file_path = ($_SERVER['DOCUMENT_ROOT'] . "/$fileupload_dir_name/$file");
// Check is file exists and rename it.
if (file_exists($upload_file_path)) {
	rename ($upload_file_path, $_SERVER['DOCUMENT_ROOT'] . "/$fileupload_dir_name/$upload_newname") or die ("$l_upload19");
	echo "$p<b>$file</b> $l_upload20: <b>$upload_newname</b>.$p2";
}

// Redirect to upload page.
if ($su == "on") {
	$upload_redirect = $admin_redirect;
} else {
	$upload_redirect = $edit_redirect;
}
echo "<script type=\"text/javascript\">
<!--
var URL   = \"upload.php\"
var speed = $upload_redirect
function reload() {
location = URL
}
setTimeout(\"reload()\", speed);
//-->
</script>
$p
$l_upload15
$p2";

// Include footer if "on" in config.php.
if ($head == "on") {
	include("footer.php");
}
}

// Errorless check if directory is empty.
function is_empty_dir($dir) {
if (is_dir($dir)) {
	$dl = opendir($dir);
	if ($dl) {
		while ($name = readdir($dl)) {
			if (!is_dir("$dir/$name")) {
				return false;
				break;
			}
		}
		closedir($dl);
	} return true;
} else return true;
}

// Show readable file size function.
function upload_file_size($file) {
$file_size = 0;
if (file_exists($file)) {
	$size = filesize($file);
	if ($size < 1024) {
		$file_size = $size.' Bytes';
	} elseif (($size >= 1024) && ($size < 1024000)) {
		$file_size = round($size/1024,2).' KB';
	} elseif ($size >= 1024000) {
		$file_size = round(($size/1024)/1024,2).' MB';
	}
}
return $file_size;
}

function logout (){
// Config.php is the main configuration file.
include('config.php');
// Language file.
include("lang/$language");
// Name of page for links, title, and logout.
$logout = "upload.php";
if ($su == "on") {
	$page_name = "su";
} else {
	$page_name = "upload";
}
// Include header if "on" in config.php.
if ($head == "on") {
	include("header.php");
}
session_destroy ();
session_unset ($_SESSION['pass_hash_upload']);
echo "<script type=\"text/javascript\">
<!--
var URL   = \"upload.php\"
var speed = $edit_redirect
function reload() {
location = URL
}
setTimeout(\"reload()\", speed);
//-->
</script>";
echo "$p
$l_global10
$p2
$p
$l_global11
$p2";
// Include footer if "on" in config.php.
if ($head == "on") {
	include("footer.php");
}
}

switch(@$_REQUEST['cmd']) {
	default:
	upload1();
	break;
	
case "upload2";
	upload2(@$_POST['ftp_file'], @$_POST['upload_type'], $_POST['submit']);
	break;

case "upload_delete";
	upload_delete($_POST['file']);
	break;

case "upload_rename";
	upload_rename($_POST['file'], $_POST['upload_newname']);
	break;

case "logout";
	logout();
	break;
}

?>