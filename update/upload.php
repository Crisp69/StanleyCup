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

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>STANLEY CUP - HockeyArena.net Tournament</title>
<meta http-equiv="Content-Type" content="text/html; charset=Utf-8" >
<?include("header.php");?>
</head>
<body>
<div class="text"><br /><br />
<center><b>What do you want to do?</b><p />
<?
include("update_date.php");
//$tmp_yesterday  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
$yesterday = date("d.m.Y", $tmp_yesterday);
$today = date("d.m.Y");
$tmp_date = explode (".",$yesterday);
$update_yes = $tmp_date[0].".".$tmp_date[1].".".$tmp_date[2];
if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {$type = "po";} else {$type = "reg";}



if (File_exists("tmp/tmp_count_standings_$yesterday.txt")) {echo "<b>Download results and calculate tabs: <span class=\"mag_title_new\">DONE!</span></b>";echo " <a  href=\"login_calendar.php\">Recalculate?</a> ";}
else {echo "<a href=\"login_calendar.php\">Download results and calculate tabs</a> ";}

echo "<br /><br />";

if (File_exists("tmp/tmp_points_".$type.$yesterday.".txt")) {echo "<b>Download and calculate stats: <span class=\"mag_title_new\">DONE!</span></b>";echo " <a  href=\"login_stats.php\">Recalculate?</a> ";}
else {echo "<a href=\"login_stats.php\">Download and calculate stats</a> ";}

echo "<br /><br />";

echo "<a href=\"login_calendar_check.php\">Check games planning for next week</a><br /><br />";
echo "<a href=\"login_teams_details.php\">Download teams details</a><br /><br />";
echo "<a href=\"bo_evaluate_tickets.php\">Evaluate betting office</a><br /><br />";
echo "<a href=\"count_teams_stats.php\">Calculate teams stats</a><br /><br />";
echo "<a href=\"count_income_stats.php\">Calculate income stats</a><br /><br />";
echo "<a href=\"count_stars.php\">Calculate Stars of the weekend</a><br /><br />";
echo "<a href=\"playoff_schedule.php\">Create Playoff schedule</a><br /><br /></i>";


echo "<br /><br />
<br /><br />------------------------------------------------<br /><br />
<i>
<a href=\"edit.php\">Edit</a><br /><br />
";
?>

<br /><br /><br /><br /><br />
<div class="note">
<b>Stats, Stars, planning check and playoff:</b><br />
not implemented yet!<p>
[28.11.2010]: playoff schedule administration<br />
[22.08.2009]: Planning games check working automatically<br />
[16.08.2009]: Playoff tree generated automatically...<br />
[06.07.2009]: Stats running, Stars in development now...
</p>
</div>



</center>
</div>
</body>
</html>