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

if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {$season_type = "po";} else {$season_type = "reg";}


if($season_type == "reg") {

include("update_date.php");
//	$tmp_yesterday  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
	$yesterday = date("d.m.Y", $tmp_yesterday);	
	if(!isset($process)) {$process = 1;}
	echo $yesterday."<br>";
	//echo "Name GD SO SF SA SD S% G% GAA FOW% USG UAG SHG SHGA PPG PP PP% PPGA PEN PK%, GF, GA, FOWON, FOTOTAL<br>";
	$f_teams = fopen($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/teams/teams_list_stats.txt","r");
		while(!feof($f_teams)) {
			$goals1 = 0;
			$goals2 = 0;
			$shots1 = 0;
			$shots2 = 0;
			$fo_tot = 0;
			$fo_won = 0;
			$games = 0;
			$powerplay = 0;
			$penalty = 0;
			$unstoppable = 0;
			$unasist = 0;
			$shorthand = 0;
			$shorthandallowed = 0;
			$powergoal = 0;
			$powergoalallowed = 0;
			$shotout = 0;
			$tmp_team = explode("|", fgets($f_teams,2000));
			if($tmp_team[0] !== "") {
				$stats_file_tmp = "tmp/tmp_data_teams_stats_$yesterday.txt";
				if(file_exists($stats_file_tmp)) {
				$f = fopen($stats_file_tmp,"r");
					while(!feof($f)) {
						$tmp = explode("|==|",fgets($f,2000));
						if ((trim($tmp[1]) !== "")) {
							$tmp_hlp1 = explode("|",$tmp[1]);
							$tmp_hlp2 = explode("|",$tmp[2]);
							if(strstr(trim($tmp_hlp1[0]),trim($tmp_team[0]))){
								$goals1 = $tmp_hlp1[1]+$tmp_hlp1[2]+$tmp_hlp1[3]; 
								$goals2 = $tmp_hlp2[1]+$tmp_hlp2[2]+$tmp_hlp2[3];
								$shots1 = $tmp_hlp1[4]+$tmp_hlp1[5]+$tmp_hlp1[6]; 
								$shots2 = $tmp_hlp2[4]+$tmp_hlp2[5]+$tmp_hlp2[6];
								$fo_won = $tmp_hlp1[8];
								$fo_tot = $tmp_hlp1[8]+$tmp_hlp2[8];
								$games = 1;
								if($goals2 == 0) {$shotout = 1;}
							}
							if(strstr(trim($tmp_hlp2[0]),trim($tmp_team[0]))){
								$goals2 = $tmp_hlp1[1]+$tmp_hlp1[2]+$tmp_hlp1[3]; 
								$goals1 = $tmp_hlp2[1]+$tmp_hlp2[2]+$tmp_hlp2[3];
								$shots2 = $tmp_hlp1[4]+$tmp_hlp1[5]+$tmp_hlp1[6]; 
								$shots1 = $tmp_hlp2[4]+$tmp_hlp2[5]+$tmp_hlp2[6];
								$fo_won = $tmp_hlp2[8];
								$fo_tot = $tmp_hlp1[8]+$tmp_hlp2[8];
								$games = 1;
								if($goals2 == 0) {$shotout = 1;}
							}
							 
						}
					}fclose($f);
				}
				$playersstats_file_tmp = "tmp/tmp_data_stats_pp_$yesterday.txt";
				if(file_exists($playersstats_file_tmp)) {
				$f_p = fopen($playersstats_file_tmp,"r");
					while(!feof($f_p)) {
						$tmp_p = explode("|",fgets($f_p,2000));
						if ((trim($tmp_p[0]) !== "")) {
							$tmp_hlp3 = explode ("=",$tmp_p[0]);
							$tmp_hlp4 = explode ("=",$tmp_p[1]);
							if(strstr(trim($tmp_hlp3[0]),trim($tmp_team[0]))){
								if(($tmp_hlp3[1]=="PIM") && (!strstr($tmp_p[2],"zredukoval hru"))) {
									$penalty = $penalty + 1;
								}
								if(($tmp_hlp3[1]=="GOAL") && (strstr($tmp_p[2],"*USG*"))) {
									$unstoppable = $unstoppable + 1;
								}
								if(($tmp_hlp3[1]=="GOAL") && (strstr($tmp_p[2],"(bez asistencie)"))) {
									$unasist = $unasist + 1;
								}
								if(($tmp_hlp3[1]=="GOAL") && (strstr($tmp_p[2],"--SH"))) {
									$shorthand = $shorthand + 1;
								}
								if(($tmp_hlp3[1]=="GOAL") && (strstr($tmp_p[2],"--PP"))) {
									$powergoal = $powergoal + 1;
								}
							}
							if(strstr(trim($tmp_hlp4[0]),trim($tmp_team[0]))){
								if(($tmp_hlp4[1]=="POWERPLAY") && (!strstr($tmp_p[2],"zredukoval hru"))) {
									$powerplay = $powerplay + 1;
								}
								if(($tmp_hlp4[1]=="G_ALLOWED") && (strstr($tmp_p[2],"--SH"))) {
									$shorthandallowed = $shorthandallowed + 1;
								}
								if(($tmp_hlp4[1]=="G_ALLOWED") && (strstr($tmp_p[2],"--PP"))) {
									$powergoalallowed = $powergoalallowed + 1;
								}
							}
						}
					}fclose($f_p);
				}
				$oldstats_file_tmp = "tmp/teams".$current_season."_".$yesterday.".txt";
				if(file_exists($oldstats_file_tmp)) {
				$f_s = fopen($oldstats_file_tmp,"r");
					while(!feof($f_s)) {
						$tmp_s = explode("|",fgets($f_s,2000));
						if ((trim($tmp_s[0]) !== "")) {
							if(trim($tmp_team[2]) == $tmp_s[0]) {
								$goals1 = $goals1 + $tmp_s[21];
								$goals2 = $goals2 + $tmp_s[22];
								$shots1 = $shots1 + $tmp_s[3];
								$shots2 = $shots2 + $tmp_s[4];
								$fo_tot = $fo_tot + $tmp_s[24];
								$fo_won = $fo_won + $tmp_s[23];
								$games = $games + $tmp_s[25];
								$powerplay = $powerplay + $tmp_s[15];
								$penalty = $penalty + $tmp_s[18];
								$unstoppable = $unstoppable + $tmp_s[10];
								$unasist = $unasist + $tmp_s[11];
								$shorthand = $shorthand + $tmp_s[12];
								$shorthandallowed = $shorthandallowed + $tmp_s[13];
								$powergoal = $powergoal + $tmp_s[14];
								$powergoalallowed = $powergoalallowed + $tmp_s[17];
								$shotout = $shotout + $tmp_s[2];
							}
						}
					}fclose($f_s);
				}



				$team = trim($tmp_team[2]);
				$gf[$team] = $goals1;
				$ga[$team] = $goals2;
				$gd[$team] = $goals1 - $goals2;
				$sf[$team] = $shots1;
				$sa[$team] = $shots2;
				$sd[$team] = $shots1 - $shots2;
				if($shots1 == 0) {$s_per[$team] = 0;} else {$s_per[$team] = number_format(($goals1 / $shots1)*100,2);}
				if($shots2 == 0) {$g_per[$team] = 0;} else {$g_per[$team] = number_format((1-$goals2 / $shots2)*100,2);}
				$so[$team] = $shotout;
				if($games == 0) {$gaa[$team] = 0;} else {$gaa[$team] = number_format(($ga[$team] / $games),2);}
				if($fo_tot == 0) {$fow_per[$team] = 0;} else {$fow_per[$team] = number_format(($fo_won / $fo_tot)*100,2);}
				$g_played[$team] = $games;
				$usg[$team] = $unstoppable;
				$uag[$team] = $unasist;
				$shg[$team] = $shorthand;
				$shga[$team] = $shorthandallowed;
				$ppg[$team] = $powergoal;
				$pen[$team] = $penalty; 
				$pp[$team] = $powerplay;
				if($powerplay == 0) {$pp_per[$team] = 0;} else {$pp_per[$team] = number_format(($powergoal / $powerplay)*100,2);}
				$ppga[$team] = $powergoalallowed;
				if($penalty == 0) {$pk_per[$team] = 0;} else {$pk_per[$team] = number_format((1-$powergoalallowed / $penalty)*100,2);}
				$fo_w[$team] = $fo_won;
				$fo_t[$team] = $fo_tot;
				
				
				$team_row = $team."|".$gd[$team]."|".$so[$team]."|".$sf[$team]."|".$sa[$team]."|".$sd[$team]."|".$s_per[$team]."|".$g_per[$team]."|".$gaa[$team]."|".$fow_per[$team]."|".$usg[$team]."|".$uag[$team]."|".$shg[$team]."|".$shga[$team]."|".$ppg[$team]."|".$pp[$team]."|".$pp_per[$team]."|".$ppga[$team]."|".$pen[$team]."|".$pk_per[$team]."|-------------|".$gf[$team]."|".$ga[$team]."|".$fo_w[$team]."|".$fo_t[$team]."|".$g_played[$team]."|".trim($tmp_team[3])."|\n";
				
				$team_rows[] = $team_row;
				//echo $team."|".$gd[$team]."|".$so[$team]."|".$sf[$team]."|".$sa[$team]."|".$sd[$team]."|".$s_per[$team]."|".$g_per[$team]."|".$gaa[$team]."|".$fow_per[$team]."|".$usg[$team]."|".$uag[$team]."|".$shg[$team]."|".$shga[$team]."|".$ppg[$team]."|".$pp[$team]."|".$pp_per[$team]."|".$ppga[$team]."|".$pen[$team]."|".$pk_per[$team]."|-------------|".$gf[$team]."|".$ga[$team]."|".$fo_w[$team]."|".$fo_t[$team]."|".$g_played[$team]."|<br>";
				
				//Name GD SO SF SA SD S% G% GAA FOW% USG UAG SHG SHGA PPG PP PP% PPGA PEN PK%, GF, GA, FOWON, FOTOTAL
				
				
			}
		}fclose($f_teams);
	echo "<br><a target=\"_blank\" href=\"edit.php?file=data/teams/teams_list_stats.txt\">edit</a>";


	//write

	echo "<center><br /><form name=\"write_stats_round\" method=\"post\">";
	echo "<br /><textarea  class=\"list\" name=\"write_data_teams_stats\" cols=\"130\" rows=\"30\" >";
	foreach ($team_rows as $team_row) {
		echo $team_row;
	}
	echo "</textarea><br><br>";
	echo "\n<input type=\"hidden\" name=\"ok1\" value=\"ok\">\nwrite teams stats --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\" />\n</form>";


	if($ok1 == "ok") {
			$file_tmp_data_stats = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/stats/teams".$current_season.".txt";
			$write_data_stats = StripSlashes($write_data_teams_stats."\n");
			$fp = FOpen ($file_tmp_data_stats, "w");
			FWrite ($fp, $write_data_stats);
			FClose ($fp);
	$ok2 = "ok";
    
    $update_file = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/data/update".$current_season.".txt";
    if (File_exists($update_file)) {
		$old_update_file = FOpen($update_file, "r");
		$data_old_update_file = FRead ($old_update_file, filesize($update_file));
	fclose($old_update_file);}
    $update_text = time()."|teams stats|teams_stats|\n";
	$yes_update_file = FOpen ($update_file, "w");
	FWrite ($yes_update_file, $update_text.$data_old_update_file);
	Fclose ($yes_update_file);

	}

	if ($ok2 == "ok") {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=upload.php\">";}    
}
else {
	echo "teams stats not updated for playoffs!!!<br><br> <a href=\"upload.php\">continue</a>";
}


?>



</div>
</body>
</html>