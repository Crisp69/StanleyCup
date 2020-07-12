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
		<form action=\"count_stats.php\" method=\"post\" name=\"form1\" onsubmit=\"return obfuscate()\">
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
<?include("header.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
</head>
<body>
<div class="text">


<?

if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {$stats = "points".$current_season."po";} else {$stats = "points".$current_season."reg";}


$stats_file = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/stats/$schedule.txt";

include("update_date.php");
//$tmp_yesterday  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
$yesterday = date("d.m.Y", $tmp_yesterday);	


if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {$type = "po";} else {$type = "reg";}
			$file_write_stats_round_defs_new = "tmp/tmp_defs".$current_season.$type."_".$yesterday.".txt";
			$file_write_stats_round_players_new = "tmp/tmp_points".$current_season.$type."_".$yesterday.".txt";




//create list of players

	$file = $file_write_stats_round_players_new;
	if (file_exists($file)) {
	$f = fopen($file,"r");
	$count[$player] = 0;
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,10000));
		if (trim($tmp[0]) !== "") {
			$player = trim($tmp[2])."-".trim($tmp[12]);
			$count[$player] = $count[$player] + 1;
			if ($count[$player] == 1) {$sort[] = $player;}
			}
		}
	}
	$file_defs = $file_write_stats_round_defs_new;

	

	if (file_exists($file_defs)) {
	$f_defs = fopen($file_defs,"r");
	$count_def[$def] = 0;
	while(!feof($f_defs)) {
		$tmp_def = explode("|",fgets($f_defs,10000));
		if (trim($tmp_def[0]) !== "") {
			$def = trim($tmp_def[2])."-".trim($tmp_def[12]);
			
			$count_def[$def] = $count_def[$def] + 1;
			if ($count_def[$def] == 1) {$sortdef[] = $def;}
			}
		}
	}
	

	
	echo "<center><br /><form name=\"write_players_names\" method=\"post\"><input type=\"hidden\" class=\"list\" name=\"write_players_names\" value= \"";
	foreach ($sort as $player) {
		echo $player."\n";
	}
	echo "\"></input>\n<input type=\"hidden\" class=\"list\" name=\"write_defs_names\" value= \"";
		foreach ($sortdef as $def) {
		echo $def."\n";
	}
	echo "\"></input>\n</form><br />";	
echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1; URL=create_stats.php?ok=ok\">";

//write list of players
if ($ok == "ok") {
			//write defs
			$file_write_defs = "tmp/name_defs".$current_season.$type."_".$yesterday.".txt";
			$write_write_defs = StripSlashes($write_defs_names."\n");
			
		
			$fp_write_defs = FOpen ($file_write_defs, "w");
			FWrite ($fp_write_defs, $write_write_defs);
			FClose ($fp_write_defs);
			
echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1; URL=create_stats.php?ok1=ok\">";			
}	
if ($ok1 == "ok") {
			//write players
			$file_write_players = "tmp/name_points".$current_season.$type."_".$yesterday.".txt";
			$write_write_players = StripSlashes($write_players_names."\n");
					
			$fp_write_players = FOpen ($file_write_players, "w");
			FWrite ($fp_write_players, $write_write_players);
			FClose ($fp_write_players);

echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1; URL=count_stats_goalies.php\">";			

}


//sum za hracov...

?>



</div>
</body>
</html>