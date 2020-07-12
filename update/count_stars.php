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
		<form action=\"count_stars.php\" method=\"post\" name=\"form1\" onsubmit=\"return obfuscate()\">
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
include("update_date.php");
//$tmp_yesterday  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
$yesterday = date("d.m.Y", $tmp_yesterday);	

//sum za hracov...
if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) 
	{$type = "po";} else {$type = "reg";}



if($ok !== "ok") {
echo "<center>";


echo "<form method=\"post\" name=\"stars\">";
echo "<br />points:<br />";
echo "<table class=\"overview\" width=\"60%\" align=\"center\">";
echo "<tr><th>1st</th><th>2nd</th><th>3rd</th><th>rk</th><th>name</th><th>G</th><th>A</th><th>P</th><th>+/-</th><th>perf</th><th>shot</th><th>team</th><th>team</th><th>id</th></tr>";
$file = "tmp/points".$current_season.$type.$yesterday."_stars.txt";
if(File_exists($file)) {
	$f_players = fopen($file,"r");
	while(!feof($f_players)) {
		$tmp_stats = explode("|", fgets($f_players,2000));
		if(($tmp_stats[0] !== "\n") && ($tmp_stats[0]!=="")) {
			$go = $tmp_stats[4] + 50;
			$po = $tmp_stats[6] + 50;
			$pe = $tmp_stats[8] + 50;
					
			$points = $po.";".$go.";".$pe.";".$tmp_stats[2]."</td><td>".$tmp_stats[4]."</td><td>".$tmp_stats[5]."</td><td>".$tmp_stats[6]."</td><td>".$tmp_stats[7]."</td><td>".$tmp_stats[8]."</td><td>".$tmp_stats[9]."</td><td>".$tmp_stats[11]."</td><td>".$tmp_stats[12]."</td><td>".$tmp_stats[13];	
			$points_sort[] = $points; 
		}
	}fclose($f_players);
		
	arsort($points_sort);
	$z = 1;
	foreach ($points_sort as $points) {if ($z < 11) {
		$tmp_points_sorted = explode(";",$points);
		
		$tmp_star = explode ("</td><td>", $tmp_points_sorted[3]);
		echo "<tr><td><input name=\"first\" value=\"$tmp_star[0]|$tmp_star[8]|$tmp_star[1] goals + $tmp_star[2] asists|$tmp_star[9]\" type=\"radio\">&nbsp;</input></td><td><input name=\"second\" value=\"$tmp_star[0]|$tmp_star[8]|$tmp_star[1] goals + $tmp_star[2] asists|$tmp_star[9]\" type=\"radio\">&nbsp;</input></td><td><input name=\"third\" value=\"$tmp_star[0]|$tmp_star[8]|$tmp_star[1] goals + $tmp_star[2] asists|$tmp_star[9]\" type=\"radio\">&nbsp;</input></td><td>".$z."</td><td>".$tmp_points_sorted[3]."</td></tr>";$z++;}
	}
} else {echo "no data for $yesterday";}
echo "</table><br />";

echo "<br />defs:<br />";
echo "<table class=\"overview\" width=\"60%\" align=\"center\">";
echo "<tr><th>1st</th><th>2nd</th><th>3rd</th><th>rk</th><th>name</th><th>G</th><th>A</th><th>P</th><th>+/-</th><th>perf</th><th>shot</th><th>team</th><th>team</th><th>id</th></tr>";
$file = "tmp/defs".$current_season.$type.$yesterday."_stars.txt";
if(File_exists($file)) {
	$f_players = fopen($file,"r");
	while(!feof($f_players)) {
		$tmp_stats = explode("|", fgets($f_players,2000));
		if(($tmp_stats[0] !== "\n") && ($tmp_stats[0]!=="")) {
			$go = $tmp_stats[4] + 50;
			$po = $tmp_stats[6] + 50;
			$pe = $tmp_stats[8] + 50;
					
			$defs = $po.";".$go.";".$pe.";".$tmp_stats[2]."</td><td>".$tmp_stats[4]."</td><td>".$tmp_stats[5]."</td><td>".$tmp_stats[6]."</td><td>".$tmp_stats[7]."</td><td>".$tmp_stats[8]."</td><td>".$tmp_stats[9]."</td><td>".$tmp_stats[11]."</td><td>".$tmp_stats[12]."</td><td>".$tmp_stats[13];	
			$defs_sort[] = $defs; 
		}
	}fclose($f_players);
		
	arsort($defs_sort);
	$z = 1;
	foreach ($defs_sort as $defs) {if ($z < 11) {
		$tmp_defs_sorted = explode(";",$defs);
		$tmp_star = explode ("</td><td>", $tmp_defs_sorted[3]);
		echo "<tr><td><input name=\"first\" value=\"$tmp_star[0]|$tmp_star[8]|$tmp_star[1] goals + $tmp_star[2] asists|$tmp_star[9]\" type=\"radio\">&nbsp;</input></td><td><input name=\"second\" value=\"$tmp_star[0]|$tmp_star[8]|$tmp_star[1] goals + $tmp_star[2] asists|$tmp_star[9]\" type=\"radio\">&nbsp;</input></td><td><input name=\"third\" value=\"$tmp_star[0]|$tmp_star[8]|$tmp_star[1] goals + $tmp_star[2] asists|$tmp_star[9]\" type=\"radio\">&nbsp;</input></td><td>".$z."</td><td>".$tmp_defs_sorted[3]."</td></tr>";$z++;}
	}
} else {echo "no data for $yesterday";}
echo "</table><br />";


echo "<br />goalies:<br />";
echo "<table class=\"overview\" width=\"60%\" align=\"center\">";
echo "<tr><th>1st</th><th>2nd</th><th>3rd</th><th>rk</th><th>name</th><th>shs</th><th>svs</th><th>%</th><th>shoout</th><th>perf</th><th>team</th><th>team</th><th>id</th></tr>";
$file = "tmp/goalies".$current_season.$type.$yesterday."_stars.txt";
if(File_exists($file)) {
	$f_players = fopen($file,"r");
	while(!feof($f_players)) {
		$tmp_stats = explode("|", fgets($f_players,2000));
		if(($tmp_stats[0] !== "\n") && ($tmp_stats[0]!=="")) {
			$pc = $tmp_stats[6] + 100;
			$sh = $tmp_stats[4] + 100;
			$so = $tmp_stats[7] + 10;
				
			$match = $tmp_stats[1];
			$matches[] = $match; 	
			$goalies = $pc.";".$sh.";".$so.";".$tmp_stats[2]."</td><td>".$tmp_stats[4]."</td><td>".$tmp_stats[5]."</td><td>".$tmp_stats[6]."</td><td>".$tmp_stats[7]."</td><td>".$tmp_stats[8]."</td><td>".$tmp_stats[9]."</td><td>".$tmp_stats[10]."</td><td>".$tmp_stats[11];
				
			$goalies_sort[] = $goalies; 
		}
	}fclose($f_players);
		arsort($goalies_sort);
		$z = 1;
		foreach ($goalies_sort as $goalies) {if ($z <21) {
			$tmp_goalies_sorted = explode(";",$goalies);
			$tmp_star = explode ("</td><td>", $tmp_goalies_sorted[3]);
			if(($tmp_goalies_sorted[1] > 115) && ($tmp_goalies_sorted[0] > 190)) {echo "<tr><td><input name=\"first\" value=\"$tmp_star[0]|$tmp_star[7]|$tmp_star[3]% svs, $tmp_star[4] shotout|$tmp_star[8]\" type=\"radio\">&nbsp;</input></td><td><input name=\"second\" value=\"$tmp_star[0]|$tmp_star[7]|$tmp_star[3]% svs, $tmp_star[4] shotout|$tmp_star[8]\" type=\"radio\">&nbsp;</input></td><td><input name=\"third\" value=\"$tmp_star[0]|$tmp_star[7]|$tmp_star[3]% svs, $tmp_star[4] shotout|$tmp_star[8]\" type=\"radio\">&nbsp;</input></td><td>".$z."</td><td>".$tmp_goalies_sorted[3]."</td></tr>";$z++;}}
		}
}
echo "</table><br />";



echo "<br /><input type=\"hidden\" name=\"ok\" value=\"ok\"><input type=\"hidden\" name=\"ok1\" value=\"ok\">\nwrite stats --> <input type=\"submit\" class=\"date\" value=\"-- SELECT --\"/>\n</form><br />";
}

if (($ok1 == "ok") && ($ok == "ok")) {
	$write = $yesterday."|".$first."|".$second."|".$third."\n";
	echo $write;




	$stars_file = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/stars/star".$current_season.".txt";
	
	if ((File_Exists($stars_file)) && (Count(File($stars_file))!==0)) {
			$fp_stars_file = FOpen ($stars_file, "r");
			$data = FRead ($fp_stars_file, FileSize($stars_file));
			FClose($fp_stars_file); }
		
		
			$fp_write_stars_file = FOpen ($stars_file, "w");
			FWrite ($fp_write_stars_file, $write.$data);
			FClose ($fp_write_stars_file);
            
   	$update_file = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/data/update".$current_season.".txt";
    if (File_exists($update_file)) {
		$old_update_file = FOpen($update_file, "r");
		$data_old_update_file = FRead ($old_update_file, filesize($update_file));
	fclose($old_update_file);}
    $update_text = time()."|stars|stars|\n";
	$yes_update_file = FOpen ($update_file, "w");
	FWrite ($yes_update_file, $update_text.$data_old_update_file);
	Fclose ($yes_update_file);


function parseteamnamesearch($team)
{
	
	$f = fopen($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/default/teams_list.txt", "r");
	while (!feof($f)) {
		$tmp = explode("|", fgets($f, 2000));
		if (trim($tmp[0]) !== "") {
			if ($team == trim($tmp[1])) {
				echo $tmp[0];
			}
		}
	}
}	
	
	echo "<hr>";
echo "<br /><br />DONE!";
echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=upload.php\">";	
	}			
 

?>