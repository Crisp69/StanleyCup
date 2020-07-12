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
		<form action=\"calendar_check.php\" method=\"post\" name=\"form1\" onsubmit=\"return obfuscate()\">
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
<meta http-equiv="Content-Type" content="text/html; charset=Utf-8" >
</head>
<body>
<div class="text"><br /><br />

<?php





//$file = "teams.txt";
	

include ($_SERVER['DOCUMENT_ROOT']."/stanleycup/settings.php");


$next_season = $current_season + 1;
if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/schedule".$next_season.".txt")) {$current_season = $current_season +1;}

if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {$schedule = "playoff".$current_season;} else {$schedule = "schedule".$current_season;}


$schedule = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/$schedule.txt";




echo "<center>";

$f = fopen($schedule,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if ((trim($tmp[0]) !== "") && $tmp[11] == "?") {
			if($tmp[6] < 10) {$month = "0".$tmp[6];} else {$month = $tmp[6];}
			
			$date = mktime(0, 0, 0, $tmp[6], $tmp[5], $tmp[7]); 
			$dwn_time = mktime(0, 0, 0, date("m"), date("d")+10, date("Y"));
			
			
			
			$tmp_yesterday  = mktime(0, 0, 0, $tmp[6], $tmp[5]+1, $tmp[7]);
			$yesterday_dwn = date("d.m", $date);
			$yesterday = date("d.m.Y", $tmp_yesterday);
			$today = date("d.m", $tmp_yesterday);
			$tmp_date = explode (".",$yesterday);
			$update_yes = $tmp_date[0].".".$tmp_date[1].".".$tmp_date[2];
			
			
			
			$update_date = $tmp[5].".".$month.".".$tmp[7];
			
			if($date < $dwn_time) {
			$team_long_1 = $tmp[1];
			$team_long_2 = $tmp[2];
			$team_id_1 = $tmp[3];
			$team_id_2 = $tmp[4];
			$team_short_1 = $tmp[8];
			$team_short_2 = $tmp[9];
			$group = $tmp[0];
			

			include("update_settings.php");
			if($team_id_1 == $my_team) {$link = "$prefix/index.php?p=public_team_info_calendar.php&team_id=$team_id_2";}
			else {$link = "$prefix/index.php?p=public_team_info_calendar.php&team_id=$team_id_1";}
			
			
			curl_setopt($ch, CURLOPT_URL, $link);
			$result = curl_exec ($ch);
			curl_close ($ch); 
			$read = $result;
			
			
			// this gets rid of most of the CSS in the page
			$read = preg_replace("/<head>(.*)<\/select>/ism","",$read);
            $read = str_replace("- 22:00", "", $read);
            $read = str_replace("- 21:00", "", $read);
            $read = str_replace("- 19:00", "", $read);
            $read = str_replace("- 20:00", "", $read);
			$read = str_replace("Benny's Hawks", "Bennys Hawks", $read);
			$read = preg_replace("/(.*)<\/ul>/ism","",$read);
			$read = preg_replace("/(.*)$yesterday_dwn&nbsp;/ism","",$read);
			$read = preg_replace("/$today&nbsp;(.*)/ism","",$read);
			$read = preg_replace("/<td class=\"center\" width='25%' style='white-space:normal;'>/","",$read);
			$read = preg_replace("/<a href=/","",$read);
			$read = preg_replace("/style='font-weight:normal;'>/","",$read);
			$read = preg_replace("/index.php\?p=public_team_info_basic.php&team_id=/","",$read);
			$read = preg_replace("/index.php\?p=public_match_info.php&match_id=/","",$read);
			$read = preg_replace("/index.php\?p=public_match_report.php&match_id=/","",$read);
			$read = preg_replace("/\' style=\'color:blue; font-weight:normal;'>/","",$read);
			$read = preg_replace("/\' style=\'color:red; font-weight:normal;\'>/","",$read);
			$read = preg_replace("/\' style=\'color:black; font-weight:normal;\'>/","",$read);
			$read = preg_replace("/<td class=stdc25 style=width: 6%;>/","",$read);
			$read = preg_replace("/<td align=left style=width: 32%;>/","",$read);
			$read = preg_replace("/\' style=\'color:blue; font-weight:normal;\'>/","",$read);
			$read = preg_replace("/style=\'color:black; font-weight:normal;\'>/","",$read);
			$read = strip_tags($read);
			$read = preg_replace("/\\n/","",$read);
			$read = preg_replace("/\\t/","",$read);
			$read = preg_replace("/\>/","",$read);
			$read = trim($read);
			$read = str_replace("      ", "|", $read);
			$read = str_replace("\"", "", $read);
			
			$read = str_replace("'", "|", $read);
			$read = str_replace("||", "|", $read);
			$read = str_replace("|    |", "|", $read);
			$read = preg_replace("/<script[^>]*?>.*?<\/script>/ism","",$read);
			$tmp_read = explode ("|",$read);
			$tmp_score = explode (":",$tmp_read[5]);
//echo $read;
//echo $tmp_read[5]." ".$team_id_2." ".$tmp_read[2]." ".$team_id_1;


			if((($team_id_1 == $tmp_read[2])&&($team_id_2 == $tmp_read[5])) || (($team_id_2 == $tmp_read[2])&&($team_id_1 == $tmp_read[5]))) {
				
					$write = $yesterday_dwn." ".$team_long_1." - ".$team_long_2." - ok";
					
					echo "$write<br />";
				
			}
			else {
			$write_msg = $yesterday_dwn." ".$team_long_1." - ".$team_long_2;
				/*echo $team_long_1."|".$team_long_2."|".$team_id_1."|".$team_id_2."|";*/
			$write = "<br /><b>$yesterday_dwn <a target=\"_blank\" href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&team_id=$team_id_1\">$team_long_1</a> - <a target=\"_blank\" href=\"http://www.hockeyarena.net/sk/index.php?p=public_team_info_basic.php&team_id=$team_id_2\">$team_long_2</a> - NO</b><br />";
			
			echo "$write";
			
			$team_list = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/teams/teams.txt";
			$f5 = fopen($team_list,"r");
				while(!feof($f5)) {
				$tmp_teams = explode("|",fgets($f5,2000));
				if ($team_id_1 == $tmp_teams[3]) {$manager1 = $tmp_teams[4]; echo $manager1."|";}
				if ($team_id_2 == $tmp_teams[3]) {$manager2 = $tmp_teams[4]; echo $manager2."|";}
				}
			
			
			$orig_text = "Hi\n this message is an result of automatic game planning check.\n\n there is a problem in your calendar with following game:\n\n $write_msg \n could you please check it and fix it?\n\n thank you\n\n \n stanleycup.crash.sk\n\n\n**********************\nmessage sent to: $manager1, $manager2";
			echo "<table width=\"40%\" align=\"center\"><tr><td>$team_long_1:</td><td>";
			echo "<form method=\"post\" action=\"http://www.hockeyarena.net/sk/index.php?p=manager_mail_new_mail_sql.php\" target=\"_blank\">";
			echo "<input name=\"text\" type=\"hidden\" value=\"$orig_text\">";
			echo "<input name=\"whom\" type=\"hidden\" value=\"$manager1\">";
			echo "<input name=\"subject\" type=\"hidden\" value=\"Stanley Cup\">";
			echo "<input type=\"submit\" class=\"date\" value=Po�li></form></td><td>";
			echo "$team_long_2:</td><td><form method=\"post\" action=\"http://www.hockeyarena.net/sk/index.php?p=manager_mail_new_mail_sql.php\" target=\"_blank\">";
			echo "<input name=\"text\" type=\"hidden\" value=\"$orig_text\">";
			echo "<input name=\"whom\" type=\"hidden\" value=\"$manager2\">";
			echo "<input name=\"subject\" type=\"hidden\" value=\"Stanley Cup\">";
			echo "<input type=\"submit\" class=\"date\" value=Po�li></form></td></tr></table>";
			echo "<br />";
		}
	
	if($tmp[12] == 2) {echo "<hr>";} 			
	}


	}
}
fclose($f);


echo "<a href=\"upload.php\">back</a>";


//if ($ok == "ok") {
//	$file_schedule = $schedule;
//	
//			$write_schedule = StripSlashes($write_schedule."\n");
//			$fp_schedule = FOpen ($file_schedule, "w");
//			FWrite ($fp_schedule, $write_schedule);
//			FClose ($fp_schedule);
//			
//	$done = "done";	
//	echo "<center><br />done!<center>";
//	
//if($done == "done") {
//	
//	if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=upload.php\">";} else {
//	
//	
//	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=count_tabs.php\">";}
//	}
//}
?>
</div>
</body>
</html>