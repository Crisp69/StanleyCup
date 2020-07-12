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
if(!isset($process)) {$process = 1;}
echo $yesterday;
if ($process == "1") {
// kontrola poctu hracov podla timu
$stats_file_tmp = "tmp/tmp_data_stats_pp_$yesterday.txt";
$f_teams = fopen($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/teams/teams_list_stats.txt","r");
if(file_exists($stats_file_tmp)) {
echo "<br /><b>players + defs session</b><br />check number of players read from each team / watch for anything else than 15 or 20!!!<br /><br /><table width=\"50%\" align=\"center\"><tr valign=\"top\"><td>";
$u = 1;$w = 1;
while(!feof($f_teams)) {
	if($tmp_team[0] !== "") {if ($w == 11) {echo "</td><td>"; $w = 0;} else {$w++;}
		$tmp_team = explode("|", fgets($f_teams,2000));
			$z = 0;
			$f = fopen($stats_file_tmp,"r");
			while(!feof($f)) {
				$tmp = explode("|",fgets($f,2000));
                $tmp_2 = explode("=", $tmp[0]);
				if ((trim($tmp_2[0]) !== "")) {
					
					if(trim($tmp_2[0]) == trim($tmp_team[0])){
						$z = $z + 1;
						
					}
				}
		}fclose($f);
		$team = $tmp_team[1];
		$count[$team] = $z;
		echo $u. ". ".$team." - ".$count[$team]."<br />";
		
	}$u++;
}fclose($f_teams); 
echo "</tr></table><br />";	
	
	

//zapis hracov
$stats_file_tmp = "tmp/tmp_data_stats_pp_$yesterday.txt";
$f = fopen($stats_file_tmp,"r");
            $pp = 0;
            $sh = 0;
            $usg = 0;
            $pim[$player] = 0;
        $count[$player] = 0;
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if ((trim($tmp[0]) !== "")) {
            $tmp_2 = explode("=", $tmp[0]);
			$tmp_hlp = explode(";",$tmp[2]);
			$tmp_player = explode("--", $tmp[2]);
            $tmp_player2 = explode(" -", $tmp_player[1]);
            $player = trim($tmp_player2[0]);
				$f_teams = fopen($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/teams/teams_list_stats.txt","r");
					while(!feof($f_teams)) {
						$tmp_team = explode("|", fgets($f_teams,2000));
						if($tmp_team[0] !== "") {
						if(trim($tmp_2[0]) == trim($tmp_team[0])){
							$team = $tmp_team[1]."|".trim($tmp_team[2]);
							$i[$team] = $i[$team] + 1;
							$team_short = trim($tmp_team[2]);
							$team_count = $tmp_team[1];
							}
						}
					}fclose($f_teams);
            if(strstr(($tmp[0]),"PIM") || strstr(($tmp[2]),"--SH") || strstr(($tmp[2]),"--PP") || strstr(($tmp[2]),"*USG*")) {
            $count[$player] = $count[$player] + 1;
            if ($count[$player] == 1) {
                $name_list = $player."|".$tmp_2[0]."|".$team."|\n";$name_lists[]=$name_list;}
            }
			
            
                        
		}
	}





//write

echo "<center><br /><form name=\"write_namelist\" method=\"post\"><input type=\"hidden\" class=\"list\" name=\"write_stats_round_pp\" value= \"";
foreach ($name_lists as $name_list) {
	echo $name_list;
}
echo "\"></input>\n<input type=\"hidden\" name=\"ok1\" value=\"ok\">\ncreate list of players --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\" />\n</form>";
}
if($ok1 == "ok") {
	if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {$type = "po";} else {$type = "reg";}
			
			
			//write players
			
			$file_write_stats_round_players_pp = "tmp/points".$current_season.$type.$yesterday."_pp.txt";
			
			
				$yes = FOpen ($file_write_stats_round_players_pp, "w");
				FWrite ($yes, $write_stats_round_pp);
				Fclose ($yes);
			

echo "running...<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=count_stats_pp_round.php\">";

	}
}

?>



</div>
</body>
</html>