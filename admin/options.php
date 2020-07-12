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
if (is_file("$datadir/admin_pass.php")) {
include ("$datadir/admin_pass.php");
}
// Language file.
include("lang/$language");
// Name of page for links, title, and logout.
$logout = "options.php";
if ($su == "on") {
	$page_name = "su";
} else {
	$page_name = "options";
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
	if(!empty($_POST['pass_hash_admin'])) {
		// Crypt, hash, and store password in session.
		$_SESSION['pass_hash_admin'] = crypt(md5($_POST['pass_hash_admin']), md5($_POST['pass_hash_admin']));
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
	} if (($_SESSION['pass_hash_admin'] != $admin_password) || ($_POST['pass_string_hash'] != $string_response) || ($_POST['agenthash'] != $agent_response)) {
		// Otherwise, give login.
		if ($head == "on") {
			include("header.php");
		}
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
			document.form1.pass_hash_admin.value = hex_sha256(document.form1.pass_admin.value);
			document.form1.pass_hash2.value = hex_md5(document.form1.pass_admin.value);
			document.form1.string_hash.value = hex_md5(document.form1.string.value);
			document.form1.pass_string_hash.value =  hex_md5(document.form1.string_hash.value  + document.form1.pass_hash2.value);
			document.form1.agenthash.value = hex_md5(document.form1.agent.value);
			document.form1.pass_admin.value = \"\";
			document.form1.string.value = \"\";
			document.form1.agent.value = \"\";
			document.form1.jscript.value = \"on\";
			return true;
		}
		</script>
		<form action=\"options.php\" method=\"post\" name=\"form1\" onsubmit=\"return obfuscate()\">
		$p
		<input name=\"jscript\" type=\"hidden\" value=\"off\" />
		<input name=\"pass_hash_admin\" type=\"hidden\" value=\"\" />
		<input name=\"pass_hash2\" type=\"hidden\" value=\"\" />
		<input name=\"string_hash\" type=\"hidden\" value=\"\" />
		<input name=\"pass_string_hash\" type=\"hidden\" value=\"\" />
		<input name=\"agenthash\" type=\"hidden\" value=\"\" />
		<input name=\"string\" type=\"hidden\" value=\"$rand_string\" />
		<input name=\"agent\" type=\"hidden\" value=\"$agent\" />
		<input type=\"password\" name=\"pass_admin\" />
		<input type=\"submit\" value=\"$l_global14\" />
		$p2
		</form>";
		if ($head == "on") {
			include("footer.php");
		}
		exit();
	}
} else {
}
// End password protection.


// Password on/off check and reset or use existing password.
if (empty($admin_password)) {
	$admin_empty_pass = "false";
} else {
	$admin_empty_pass = "true";
}
if (empty($user_password)) {
	$user_empty_pass = "false";
} else {
	$user_empty_pass = "true";
}
if (empty($upload_password)) {
	$upload_empty_pass = "false";
} else {
	$upload_empty_pass = "true";
}
if (($password_protect == "on") && ($admin_empty_pass == "false")) {
	$admin_pass_reset = "<input type=\"password\" name=\"opt_empty_admin_password\" value=\"\" /> <i>($l_opt128)</i>";
} else {
	$admin_pass_reset = "<input type=\"password\" name=\"opt_empty_admin_password\" value=\"\" />";
}
if (($password_protect == "on") && ($user_empty_pass == "false")) {
	$user_pass_reset = "<input type=\"password\" name=\"opt_empty_user_password\" value=\"\" /> <i>($l_opt128)</i>";
} else {
	$user_pass_reset = "<input type=\"password\" name=\"opt_empty_user_password\" value=\"\" />";
}
if (($password_protect == "on") && ($upload_empty_pass == "false")) {
	$upload_pass_reset = "<input type=\"password\" name=\"opt_empty_upload_password\" value=\"\" /> <i>($l_opt128)</i>";
} else {
	$upload_pass_reset = "<input type=\"password\" name=\"opt_empty_upload_password\" value=\"\" />";
}
if ($password_protect = "on") {
	$pass_jscript = "<script language=\"JavaScript\" type=\"text/javascript\" src=\"jscripts/crypt/sha256.js\"></script>
	<script language=\"JavaScript\" type=\"text/javascript\">
	function passcreate() {
		document.form2.pwdhashadmin.value = hex_sha256(document.form2.opt_empty_admin_password.value);
		document.form2.pwdhashuser.value = hex_sha256(document.form2.opt_empty_user_password.value);
		document.form2.pwdhashupload.value = hex_sha256(document.form2.opt_empty_upload_password.value);
		document.form2.opt_empty_admin_password.value = \"\";
		document.form2.opt_empty_user_password.value = \"\";
		document.form2.opt_empty_upload_password.value = \"\";
		document.form2.jscript2.value = \"on\";
		return true;
	}
	</script>
	<form action=\"options.php\" method=\"post\" name=\"form2\" onsubmit=\"return passcreate()\">
	$p
	<input name=\"jscript2\" type=\"hidden\" value=\"off\" />
	<input name=\"pwdhashadmin\" type=\"hidden\" value=\"\" />
	<input name=\"pwdhashuser\" type=\"hidden\" value=\"\" />
	<input name=\"pwdhashupload\" type=\"hidden\" value=\"\" />
	<input type=\"hidden\" name=\"cmd\" value=\"options2\" />
	$p2";
} else {
	$pass_jscript = $p;
}

// Password storage manipulation.
$admin_emptypass_test = crypt(md5($pwdhashadmin), md5($pwdhashadmin));
if ($admin_emptypass_test == "faPhwPDI5p8Ho") {
	$admin_pass_exist = "false";
} else {
	$admin_pass_exist = "true";
}
if (($opt_password_protect == "on") && ($admin_pass_exist == "true")) {
$store_admin_password = crypt(md5($pwdhashadmin), md5($pwdhashadmin));
$admin_comments = "<?php $admin_password = '$store_admin_password'; ?>";
$open = fopen("$opt_datadir/admin_pass.php", 'wb');
fwrite($open, $admin_comments);
fclose($open);
} else {
}
$user_emptypass_test = crypt(md5($pwdhashuser), md5($pwdhashuser));
if ($user_emptypass_test == "faPhwPDI5p8Ho") {
	$user_pass_exist = "false";
} else {
	$user_pass_exist = "true";
}
if (($opt_password_protect == "on") && ($user_pass_exist == "true")) {
$store_user_password = crypt(md5($pwdhashuser), md5($pwdhashuser));
$user_comments = "<?php $user_password = '$store_user_password'; ?>";
$open = fopen("$opt_datadir/user_pass.php", 'wb');
fwrite($open, $user_comments);
fclose($open);
} else {
}
$upload_emptypass_test = crypt(md5($pwdhashupload), md5($pwdhashupload));
if ($upload_emptypass_test == "faPhwPDI5p8Ho") {
	$upload_pass_exist = "false";
} else {
	$upload_pass_exist = "true";
}
if (($opt_password_protect == "on") && ($upload_pass_exist == "true")) {
$store_upload_password = crypt(md5($pwdhashupload), md5($pwdhashupload));
$upload_comments = "<?php $upload_password = '$store_upload_password'; ?>";
$open = fopen("$opt_datadir/upload_pass.php", 'wb');
fwrite($open, $upload_comments);
fclose($open);
} else {
}


switch(@$_REQUEST['cmd']) {
	default:
	options();
	break;

case "options2";
	options2($_POST['jscript2'], $_POST['pwdhashadmin'], $_POST['pwdhashuser'], $_POST['pwdhashupload'], $_POST['opt_language'], $_POST['opt_page_title'], $_POST['opt_samplename'], $_POST['opt_sampletext'], $_POST['opt_adminlink'], $_POST['opt_su'], $_POST['opt_multi'], $_POST['opt_ht_select'], $_POST['opt_admin_ignore1'], $_POST['opt_admin_ignore2'], $_POST['opt_admin_ignore3'], $_POST['opt_admin_ignore4'], $_POST['opt_admin_ignore5'], $_POST['opt_password_protect'], $_POST['opt_empty_admin_password'], $_POST['opt_empty_user_password'], $_POST['opt_empty_upload_password'], $_POST['opt_fileupload'], $_POST['fileindex'], $_POST['fileindexview'], $_POST['fileindexdelete'], $_POST['opt_upload_process'], $_POST['opt_ftp_user'], $_POST['opt_ftp_pass'], $_POST['opt_ftp_path'], $_POST['opt_fileupload_dir_name'], $_POST['opt_up_ignore1'], $_POST['opt_up_ignore2'], $_POST['opt_up_ignore3'], $_POST['opt_up_ignore4'], $_POST['opt_up_ignore5'], $_POST['opt_imagedir_onoff'],$_POST['opt_imagedir'], $_POST['imageindex'], $_POST['imageindexview'], $_POST['imageindexdelete'], $_POST['opt_setup'], $_POST['opt_edit_redirect'], $_POST['opt_admin_redirect'], $_POST['opt_edit_width'], $_POST['opt_edit_height'], $_POST['opt_tiny'], $_POST['opt_tiny_compressor'], $_POST['opt_advhr'], $_POST['opt_advimage'], $_POST['opt_advlink'], $_POST['opt_autosave'], $_POST['opt_backcolor'], $_POST['opt_contextmenu'], $_POST['opt_copy'], $_POST['opt_cut'], $_POST['opt_directionality'], $_POST['opt_emotions'], $_POST['opt_filemanager'], $_POST['opt_fontselect'], $_POST['opt_fontsizeselect'], $_POST['opt_forecolor'], $_POST['opt_fullscreen'], $_POST['opt_ibrowser'], $_POST['opt_iespell'], $_POST['opt_inlinepopups'], $_POST['opt_insertdatetime'], $_POST['opt_insertdatetime_dateFormat'], $_POST['opt_insertdatetime_timeFormat'], $_POST['opt_layer'], $_POST['opt_liststyle'], $_POST['opt_media'], $_POST['opt_nonbreaking'], $_POST['opt_noneditable'], $_POST['opt_paste'], $_POST['opt_paste_create_paragraphs'], $_POST['opt_paste_create_linebreaks'], $_POST['opt_paste_use_dialog'], $_POST['opt_paste_auto_cleanup_on_paste'], $_POST['opt_paste_convert_middot_lists'], $_POST['opt_paste_unindented_list_class'], $_POST['opt_paste_convert_headers_to_strong'], $_POST['opt_paste_remove_spans'], $_POST['opt_paste_remove_styles'], $_POST['opt_paste_replace_list'], $_POST['opt_paste_strip_class_attributes'], $_POST['opt_preview'], $_POST['opt_plugin_preview_width'], $_POST['opt_plugin_preview_height'], $_POST['opt_print'], $_POST['opt_searchreplace'], $_POST['opt_style'], $_POST['opt_table'], $_POST['opt_visualchars'], $_POST['opt_xhtmlxtras'], $_POST['opt_zoom'],  $_POST['opt_head'], $_POST['opt_textdir'], $_POST['opt_datadir'], $_POST['opt_pagepath'], $_POST['opt_p'], $_POST['opt_p2']);
	break;

case "logout";
	logout();
	break;
}

?>