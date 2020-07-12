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
		<form action=\"count_stats_goalies.php\" method=\"post\" name=\"form1\" onsubmit=\"return obfuscate()\">
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

if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {$schedule = "points".$current_season."po";} else {$stats = "points".$current_season."reg";}


$stats_file = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/stats/$schedule.txt";

include("update_date.php");
//$tmp_yesterday  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
$yesterday = date("d.m.Y", $tmp_yesterday);	
if(!isset($process)) {$process = 1;}

if ($process == "1") {
	
//kontrola poctu brankarov podla timu
$stats_file_tmp = "tmp/tmp_data_stats_goalies_$yesterday.txt";;
$f_teams = fopen($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/teams/teams_list_stats.txt","r");
echo "<br /><b>goalies session</b><br />check number of goalies read from each team / watch for anything else than 1 or 2!!!<br /><br /><table width=\"50%\" align=\"center\"><tr valign=\"top\"><td>";
$u = 1;$w = 1;
while(!feof($f_teams)) {
	if($tmp_team[0] !== "") {if ($w == 11) {echo "</td><td>"; $w = 0;} else {$w++;}
		$tmp_team = explode("|", fgets($f_teams,2000));
			$z = 0;
			$f = fopen($stats_file_tmp,"r");
			while(!feof($f)) {
				$tmp = explode("|",fgets($f,2000));
				if ((trim($tmp[1]) !== "") && (trim($tmp[1])!== ";-")) {
					if(trim(str_replace("-","",$tmp[8])) == trim(str_replace("-","",$tmp_team[0]))){
						$z = $z + 1;
					}
				}
		}fclose($f);
		$team = $tmp_team[1];
		$count[$team] = $z;
        if($team !="") {if($count[$team] == 0) {echo "<span class=\"textred\">".$u. ". ".$team." - ".$count[$team]."</span><br />";} else {echo $u. ". ".$team." - ".$count[$team]."<br />";}}
		
	}$u++;
}fclose($f_teams); 
echo "</tr></table><br />";	
	
	

//goalies
$stats_file_tmp = "tmp/tmp_data_stats_goalies_$yesterday.txt";
$f = fopen($stats_file_tmp,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if ((trim($tmp[1]) !== "") && (trim($tmp[1])!== ";-")) {
			$tmp_hlp = explode(";",$tmp[2]);
				
				$f_teams = fopen($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/teams/teams_list_stats.txt","r");
					while(!feof($f_teams)) {
						$tmp_team = explode("|", fgets($f_teams,2000));
						if($tmp_team[0] !== "") {
						if(trim(str_replace("-","",$tmp[8])) == trim(str_replace("-","",$tmp_team[0]))){
							$team = $tmp_team[1]."|".trim($tmp_team[2]);
							$i[$team] = $i[$team] + 1;
							$sub_min = 60;
							$team_count = $tmp_team[1];
                            $sub_file = "tmp/tmp_data_stats_goalies_sub_$yesterday.txt";
                            if(File_exists($sub_file)) {
                            $f_sub = fopen($sub_file,"r");
					            while(!feof($f_sub)) {
                                $tmp_sub = explode("|", fgets($f_sub,2000));
        						if($tmp_sub[0] !== "") {
        						/*  if((strstr($tmp_sub[1],trim($tmp[7])."=Striedanie")) || strstr($tmp_sub[3],trim($tmp[7])."=Striedanie")){
        						      $sub_time = explode(":", $tmp_sub[0]);
        						      if($i[$team] == 1) {$sub_min = $sub_time[0]+1;} elseif ($i[$team] == 2) {$sub_min = 60 - $sub_time[0];} 
                                    }
                                    if((strstr($tmp_sub[0],trim($tmp[7])."=Striedanie"))){
        						      $sub_time = explode(":", $tmp_sub[1]);
        						      if($i[$team] == 1) {$sub_min = $sub_time[0]+1;} elseif ($i[$team] == 2) {$sub_min = 60 - $sub_time[0];} 
                                    }*/
                                
        						 if((strstr($tmp_sub[1],trim($tmp[8])."=Striedanie")) || strstr($tmp_sub[3],trim($tmp[7])."=Striedanie")){
        						      $sub_time = explode(":", $tmp_sub[0]);
        						      if($i[$team] == 1) {$sub_min = $sub_time[0]+($sub_time[1]/60);} elseif ($i[$team] == 2) {$sub_min = 60 - $sub_time[0]-($sub_time[1]/60);} 
                                    }
                                  if((strstr($tmp_sub[0],trim($tmp[8])."=Striedanie"))){
        						      $sub_time = explode(":", $tmp_sub[1]);
        						      if($i[$team] == 1) {$sub_min = $sub_time[0]+($sub_time[1]/60);} elseif ($i[$team] == 2) {$sub_min = 60 - $sub_time[0]-($sub_time[1]/60);} 
                                    }
      						    }
					        }
                        }
					}
                    if(trim(str_replace("-","",$tmp[9])) == trim(str_replace("-","",$tmp_team[0]))){ //tento if je novy
						$team2 = $tmp_team[2];
					}
				}
			}fclose($f_teams);
		if (trim($tmp[3]) !== "0") {if(!isset($sub_min)) {$sub_min=60;}
			if((trim($tmp[3]) == trim($tmp[4])) && (trim($tmp[3]) !== "0") && ($sub_min == 60)) {$shotout = 1;} else {$shotout = 0;}
			$goalie = $i[$team]."-".$count[$team_count]."||".trim($tmp_hlp[0])."|1|".trim($tmp[3])."|".trim($tmp[4])."|".trim($tmp[5])."|".$shotout."|".trim($tmp[7])."|".$team."|".trim($tmp[1])."|".$sub_min."||".$team2."|".$yesterday."\n";
            echo $goalie."<br>";
			$goalies[] = $goalie;
			}
		}
	}	



//write

echo "<center><br /><form name=\"write_stats_round_goalies\" method=\"post\"><input type=\"hidden\" class=\"list\" name=\"write_stats_round_goalies\" value= \"";
foreach ($goalies as $goalie) {
	echo $goalie;
}
echo "\"></input>\n<input type=\"hidden\" name=\"ok1\" value=\"ok\">\nwrite current round --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\" />\n</form>";

if($ok1 == "ok") {
	if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {$type = "po";} else {$type = "reg";}
			//write goalies
			$file_write_stats_round_goalies_old = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/stats/goalies".$current_season.$type.".txt";
			$file_write_stats_round_goalies = "tmp/goalies".$current_season.$type.$yesterday.".txt";
			
			if (!file_exists($file_write_stats_round_goalies)) {
				if (File_exists($file_write_stats_round_goalies_old)) {
					$old = FOpen($file_write_stats_round_goalies_old, "r");
					$data_old = FRead ($old, filesize($file_write_stats_round_goalies_old));
					fclose($old);
				}
				$yes = FOpen ($file_write_stats_round_goalies, "w");
				FWrite ($yes, $data_old);
				Fclose ($yes);
			}
			
			$file_write_stats_round_goalies_new = "tmp/goalies".$current_season.$type.$yesterday."_new.txt";
			$write_write_stats_round_goalies = StripSlashes($write_stats_round_goalies);
			
			if ((File_Exists($file_write_stats_round_goalies)) && (Count(File($file_write_stats_round_goalies))!==0)) {
				$fp_write_stats_round_goalies = FOpen ($file_write_stats_round_goalies, "r");
				$data_write_stats_round_goalies = FRead ($fp_write_stats_round_goalies, FileSize($file_write_stats_round_goalies));
				FClose($fp_write_stats_round_goalies); }
		
		
			$fp_write_stats_round_goalies = FOpen ($file_write_stats_round_goalies_new, "w");
			FWrite ($fp_write_stats_round_goalies, $write_write_stats_round_goalies.$data_write_stats_round_goalies);
			FClose ($fp_write_stats_round_goalies);
			
			//goalies pre stars
			$file_write_stats_round_goalies_stars = "tmp/goalies".$current_season.$type.$yesterday."_stars.txt"; 
			$fp_write_stats_round_goalies_stars = FOpen ($file_write_stats_round_goalies_stars, "w");
			FWrite ($fp_write_stats_round_goalies_stars, $write_write_stats_round_goalies);
			FClose ($fp_write_stats_round_goalies_stars);
			
echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=count_stats_goalies.php?process=2\">";
	}
}

if ($process == "2") {
//create list of players
	if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {$type = "po";} else {$type = "reg";}
	$file_write_stats_round_goalies_new = "tmp/goalies".$current_season.$type.$yesterday."_new.txt";
	
	$file = $file_write_stats_round_goalies_new;
	if (file_exists($file)) {
	$f = fopen($file,"r");
	$count[$player] = 0;
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,10000));
		if (trim($tmp[0]) !== "") {
			$player = trim($tmp[2])."-".trim($tmp[10]);
			$count[$player] = $count[$player] + 1;
			if ($count[$player] == 1) {$sort[] = $player;}
			
			}
		}
	}
	
	echo "<center><br /><form name=\"write_goalies_names\" method=\"post\"><input type=\"hidden\" class=\"list\" name=\"write_goalies_names\" value= \"";
	foreach ($sort as $player) {
		echo $player."\n";
	}
	echo "\"></input>\n<input type=\"hidden\" name=\"ok3\" value=\"ok\">\ncreate list of goalies --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\" />\n</form><br />";	

//write list of players
if (($ok3 == "ok")) {
		//	write goalies
			$file_write_goalies = "tmp/name_goalies".$current_season.$type."_".$yesterday.".txt";
			$write_goalies_names = StripSlashes($write_goalies_names."\n");
			
		
			$fp_write_goalies = FOpen ($file_write_goalies, "w");
			FWrite ($fp_write_goalies, $write_goalies_names);
			FClose ($fp_write_goalies);

		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=count_stats_pp.php\">";

		}





}




?>