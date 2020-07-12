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



include("update_date.php");
//	$tmp_yesterday  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
	$yesterday = date("d.m.Y", $tmp_yesterday);	
	if(!isset($process)) {$process = 1;}
    $folder_name = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/";
    //$folder_name = "stanleycup/data/";
	echo $yesterday."<br>";
	//echo "Name GD SO SF SA SD S% G% GAA FOW% USG UAG SHG SHGA PPG PP PP% PPGA PEN PK%, GF, GA, FOWON, FOTOTAL<br>";
	$f_teams = fopen($folder_name."teams/teams_list_stats.txt","r");
		while(!feof($f_teams)) {
            $home_inc = 0;
            $away_inc = 0;
            $home_crd = 0;
            $away_crd = 0;
            $home_gm = 0;
            $away_gm = 0;
			$tmp_team = explode("|", fgets($f_teams,2000));
			if($tmp_team[0] != "") {
				$stats_file_tmp = $folder_name."schedule/income".$current_season.".txt";
				if(file_exists($stats_file_tmp)) {
				$f = fopen($stats_file_tmp,"r");
					while(!feof($f)) {
						$tmp = explode("|",fgets($f,2000));
						if ((trim($tmp[0]) !== "")) {
                            if(($tmp_team[2] == $tmp[4]) || ($tmp_team[2] == $tmp[5])) {
                                if($tmp_team[2] == $tmp[11]) {
                                    $home_inc = $tmp[2] + $home_inc;
                                    $home_crd = $tmp[1] + $home_crd;
                                    $home_gm = $home_gm + 1;
                                    }
                                if($tmp_team[2] != $tmp[11]) {
                                    $away_inc = $tmp[2] + $away_inc;
                                    $away_crd = $tmp[1] + $away_crd;
                                    $away_gm = $away_gm + 1;
                                    }
                                    }
                                }
							}
					}fclose($f);
				
                $team = trim($tmp_team[2]);
                $h_inc[$team] = $home_inc;
                $h_crd[$team] = $home_crd;
                $h_gm[$team] = $home_gm;
                $a_inc[$team] = $away_inc;
                $a_crd[$team] = $away_crd;
                $a_gm[$team] = $away_gm;
				
				
				$team_row = $team."|".$h_inc[$team]."|".$h_crd[$team]."|".$h_gm[$team]."|".$a_inc[$team]."|".$a_crd[$team]."|".$a_gm[$team]."|\n";
				
				$team_rows[] = $team_row;
            }
		}fclose($f_teams);
	echo "<br><a target=\"_blank\" href=\"edit.php?file=data/teams/teams_list_stats.txt\">edit</a>";

	//write

	echo "<center><br /><form name=\"write_stats_round\" method=\"post\">";
	echo "<br /><textarea  class=\"list\" name=\"write_data_income_stats\" cols=\"130\" rows=\"30\" >";
	foreach ($team_rows as $team_row) {
		echo $team_row;
	}
	echo "</textarea><br><br>";
	echo "\n<input type=\"hidden\" name=\"ok1\" value=\"ok\">\nwrite income stats --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\" />\n</form>";


	if($ok1 == "ok") {
			$file_tmp_data_stats = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/stats/income".$current_season.".txt";
			$write_data_stats = StripSlashes($write_data_income_stats."\n");
			$fp = FOpen ($file_tmp_data_stats, "w");
			FWrite ($fp, $write_data_stats);
			FClose ($fp);
	$ok2 = "ok";
    
    $update_file = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/data/update".$current_season.".txt";
    if (File_exists($update_file)) {
		$old_update_file = FOpen($update_file, "r");
		$data_old_update_file = FRead ($old_update_file, filesize($update_file));
	fclose($old_update_file);}
    $update_text = time()."|income stats|stats_income|\n";
	$yes_update_file = FOpen ($update_file, "w");
	FWrite ($yes_update_file, $update_text.$data_old_update_file);
	Fclose ($yes_update_file);

	}

	if ($ok2 == "ok") {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=upload.php\">";}    

?>



</div>
</body>
</html>