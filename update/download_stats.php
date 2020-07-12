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
		<form action=\"download_stats.php\" method=\"post\" name=\"form1\" onsubmit=\"return obfuscate()\">
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
<meta http-equiv='Content-Type' content='text/html; charset=Utf-8'>

</head>
<body>
<div class="text"><br /><br />

<?php


echo "<center>stats downloaded<p></center>";



//$file = "teams.txt";
	

include ($_SERVER['DOCUMENT_ROOT']."/stanleycup/settings.php");



if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {$schedule = "playoff".$current_season;} else {$schedule = "schedule".$current_season;}


$schedule = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/$schedule.txt";
include("update_date.php");
//$tmp_yesterday  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
$yesterday = date("d.m.Y", $tmp_yesterday);
$today = date("d.m.Y");
$tmp_date = explode (".",$yesterday);
$update_yes = $tmp_date[0].".".$tmp_date[1].".".$tmp_date[2];

if($ok1 != "ok") {
    
    
    $f = fopen($schedule,"r");
    	while(!feof($f)) {
    		$tmp = explode("|",fgets($f,2000));
    		if (trim($tmp[0]) != "") {
    			
    			$update_date = $tmp[5].".".$tmp[6].".".$tmp[7];
    			
    			if($update_date == $update_yes) {
    			$id_match = trim($tmp[13]);
    
    			include("update_settings.php");
    			$link = "$prefix/index.php?p=public_match_info.php&match_id=$id_match";
    			
    			curl_setopt($ch, CURLOPT_URL, $link);
    			$result = curl_exec ($ch);
    			curl_close ($ch); 
    			$read = $result;
    			
    			
    			// this gets rid of most of the CSS in the page
    			$read = preg_replace("/<head>(.*)<\/select>/ism","",$read);
    			$read = preg_replace("/(.*)<\/ul>/ism","",$read);
    			$read = str_replace("Benny's Hawks", "Bennys Hawks", $read); 
    			$readgame = $read;
    			$read = preg_replace("/<div(.*)<table width=\"100%\" style=\'font-size: 100%;\'><tr><td align=\'center\' valign=\"top\">/ism","",$read);
    			
    
    			$read_total = preg_replace("/<table width=\"500\">(.*)/ism","",$read);
    
    			$read_team1 = preg_replace("/<\/table>(.*)/ism","",$read_total);
    			$read_team2 = preg_replace("/(.*)<table width=\"355\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">/ism","",$read_total);
    			$read_team1 = preg_replace("/<table width=\"355\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">/","",$read_team1);
    			$read_team_name1 = preg_replace("/<tr class=\"ysptblthbody1\" align=\"right\">(.*)/ism","",$read_total);
    			$read_team_name1 = strip_tags($read_team_name1);
    			$read_team_name1 = trim($read_team_name1);
    			$read_team_name1 = str_replace ("\n","",$read_team_name1);
    			$read_team_name2 = preg_replace("/<tr class=\"ysptblthbody1\" align=\"right\">(.*)/ism","",$read_team2);
    			$read_team_name2 = strip_tags($read_team_name2);
    			$read_team_name2 = trim($read_team_name2);
    			$read_team_name2 = str_replace ("\n","",$read_team_name2);
                $read_team_name1 = $read_team_name1."|".$read_team_name2;//toto je tu nove
                $read_team_name2 = $read_team_name2."|".$read_team_name1;//toto je tu nove
    			$read_goalies_team1 = preg_replace("/<td height=\"18\" class=\"ydt\" align=\"left\">(.*)/ism","",$read_team1);
    			$read_goalies_team1 = preg_replace("/<td height=\"18\" class=\"ydt\" align=\"left\">(.*)/ism","",$read_team1);
    			$read_goalies_team1 = preg_replace("/(.*)<tr class=\"sr1\" align=\"right\">/ism","",$read_goalies_team1);
    			$read_goalies_team1 = preg_replace("/<tr class=\"sr2\" align=\"right\">/ism","",$read_goalies_team1);
    			$read_goalies_team1 = str_replace("id=","|",$read_goalies_team1);
    			$read_goalies_team1 = str_replace("\">","\">|",$read_goalies_team1);
    			$read_goalies_team1 = str_replace("<a href=\"index.php?p=public_player_info.inc&","",$read_goalies_team1);
    			$read_goalies_team1 = strip_tags($read_goalies_team1);
    			$read_goalies_team1 = str_replace("\">|","|",$read_goalies_team1);
    			$read_goalies_team1 = str_replace("                ","",$read_goalies_team1);
    			$read_goalies_team1 = trim($read_goalies_team1);
    			$read_goalies_team1 = str_replace("            \n",";-",$read_goalies_team1);
    			$read_goalies_team1 = str_replace(" |","",$read_goalies_team1);
    			$read_goalies_team1 = str_replace("\n","",$read_goalies_team1);
    			$read_goalies_team1 = str_replace(";-;-;","|".$read_team_name1."-|goalie\n",$read_goalies_team1);
    			$read_goalies_team1 = str_replace("-|","|",$read_goalies_team1);
    			$read_goalies_team1 = str_replace("&nbsp;","",$read_goalies_team1);
    			$read_goalies_team1 = str_replace("Toronto Maple Leafs", "Toronto Maple Leafs|", $read_goalies_team1); //iba toto funguje!!!
    			$read_team1 = preg_replace("/(.*)<tr class=\"ysptblthbody1\" align=\"right\">/ism","",$read_team1);
    			$read_team1 = str_replace("id=","|",$read_team1);
    			$read_team1 = str_replace("\">","\">|",$read_team1);
    			$read_team1 = str_replace("<a href=\"index.php?p=public_player_info.inc&","|",$read_team1);
    			$read_team1 = strip_tags($read_team1);
    			$read_team1 = str_replace("\">","",$read_team1);
    			$read_team1 = str_replace("                ",";-",$read_team1);
    			$read_team1 = str_replace(";-|","|",$read_team1);
    			$read_team1 = str_replace("|;-;-","",$read_team1);
    			$read_team1 = trim($read_team1);
    			$read_team1 = str_replace("||","--",$read_team1);
    			$read_team1 = str_replace("\n","",$read_team1);
    			$read_team1 = str_replace("--","\n",$read_team1);
    			$read_team1 = str_replace("                           ","|".$read_team_name1,$read_team1);
    			$read_team1 = str_replace("&nbsp;","",$read_team1);
    			$read_team1 = str_replace("|||".$read_team_name1,"\n---",$read_team1);
    			$read_team1 = str_replace("Toronto Maple Leafs", "Toronto Maple Leafs|", $read_team1);//iba toto funguje!!!
                
    //			//
    //			
    			
    			$read_goalies_team2 = preg_replace("/<td height=\"18\" class=\"ydt\" align=\"left\">(.*)/ism","",$read_team2);
    			$read_goalies_team2 = preg_replace("/<td height=\"18\" class=\"ydt\" align=\"left\">(.*)/ism","",$read_team2);
    			$read_goalies_team2 = preg_replace("/(.*)<tr class=\"sr1\" align=\"right\">/ism","",$read_goalies_team2);
    			$read_goalies_team2 = preg_replace("/<tr class=\"sr2\" align=\"right\">/ism","",$read_goalies_team2);
    			$read_goalies_team2 = str_replace("id=","|",$read_goalies_team2);
    			$read_goalies_team2 = str_replace("\">","\">|",$read_goalies_team2);
    			$read_goalies_team2 = str_replace("<a href=\"index.php?p=public_player_info.inc&","",$read_goalies_team2);
    			$read_goalies_team2 = strip_tags($read_goalies_team2);
    			$read_goalies_team2 = str_replace("\">|","|",$read_goalies_team2);
    			$read_goalies_team2 = str_replace("                ","",$read_goalies_team2);
    			$read_goalies_team2 = trim($read_goalies_team2);
    			$read_goalies_team2 = str_replace("            \n",";-",$read_goalies_team2);
    			$read_goalies_team2 = str_replace(" |","",$read_goalies_team2);
    			$read_goalies_team2 = str_replace("\n","",$read_goalies_team2);
    			$read_goalies_team2 = str_replace(";-;-;","|".$read_team_name2."-|goalie\n",$read_goalies_team2);
    			$read_goalies_team2 = str_replace("-|","|",$read_goalies_team2);
    			$read_goalies_team2 = str_replace("&nbsp;","",$read_goalies_team2);
    			$read_goalies_team2 = str_replace("Toronto Maple Leafs", "Toronto Maple Leafs|", $read_goalies_team2);//iba toto funguje!!!
    			$read_team2 = preg_replace("/(.*)<tr class=\"ysptblthbody1\" align=\"right\">/ism","",$read_team2);
    			$read_team2 = str_replace("id=","|",$read_team2);
    			$read_team2 = str_replace("\">","\">|",$read_team2);
    			$read_team2 = str_replace("<a href=\"index.php?p=public_player_info.inc&","|",$read_team2);
    			$read_team2 = strip_tags($read_team2);
    			$read_team2 = str_replace("\">","",$read_team2);
    			$read_team2 = str_replace("                ",";-",$read_team2);
    			$read_team2 = str_replace(";-|","|",$read_team2);
    			$read_team2 = str_replace("|;-;-","",$read_team2);
    			$read_team2 = trim($read_team2);
    			$read_team2 = str_replace("||","--",$read_team2);
    			$read_team2 = str_replace("\n","",$read_team2);
    			$read_team2 = str_replace("--","\n",$read_team2);
    			$read_team2 = str_replace("                           ","|".$read_team_name2,$read_team2);
    			$read_team2 = str_replace("&nbsp;","",$read_team2);
    			$read_team2 = str_replace("|||".$read_team_name2,"\n---",$read_team2);
    			$read_team2 = str_replace("Toronto Maple Leafs", "Toronto Maple Leafs|", $read_team2);//iba toto funguje!!!
                //$read_team2 = $read_team2."|".$read_team_name1;
    			//$read_team2 = iconv('Utf-8', 'Windows-1250', $read_team2);
    			
    			//$read = strip_tags($read);
    			
    			//echo $read_team_name1;
    			
    			//echo $read_team_name2;
    			
    			$data_goalies1[] = $read_goalies_team1;
    			
    			$data_goalies2[] = $read_goalies_team2;
    			
    			$data_team1[] = $read_team1;
    			
    			$data_team2[] = $read_team2;
    			}
    		}
    	}
    	
    
    echo "<form name=\"write_data_stats\" method=\"post\"><textarea readonly=\"readonly\" class=\"list\" name=\"write_data_stats\" cols=\"100\" rows=\"15\" >";
    foreach ($data_team1 as $read_team1) {
    	echo $read_team1."\n";
    }
    foreach ($data_team2 as $read_team2) {
    	echo $read_team2."\n";
    }
    echo "</textarea>";
    echo "<br /><textarea readonly=\"readonly\" class=\"list\" name=\"write_data_stats_goalies\" cols=\"100\" rows=\"5\" >";
    foreach ($data_goalies1 as $read_goalies_team1) {
    	echo $read_goalies_team1."\n";
    }
    foreach ($data_goalies2 as $read_goalies_team2) {
    	echo $read_goalies_team2."\n";
    }
    echo "</textarea>";
    //echo $readgame;
    
    echo "\n<br /><input type=\"hidden\" name=\"ok1\" value=\"ok\">\n<br />write data --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\" />\n</form><br />";

}
$yesterday = date("d.m.Y", $tmp_yesterday);	
	
	
if ($ok1 == "ok") {
	$write_data_stats = str_replace("&nbsp;", "", $write_data_stats);
	$write_data_stats = str_replace("Toronto Maple Leafs&nbsp;®", "Toronto Maple Leafs ®", $write_data_stats);//toto aj tak nefunguje (asi)...
	$write_data_stats = str_replace("Toronto Maple Leafs&nbsp;™", "Toronto Maple Leafs ™", $write_data_stats);//toto aj tak nefunguje (asi)...
	
	//$write_data_stats = iconv('Utf-8', 'Windows-1250', $write_data_stats);

	$file_tmp_data_stats = "tmp/tmp_data_stats_$yesterday.txt";
			$write_data_stats = StripSlashes($write_data_stats."\n");
			$fp = FOpen ($file_tmp_data_stats, "w");
			FWrite ($fp, $write_data_stats);
			FClose ($fp);

	$write_data_stats_goalies = str_replace("&nbsp;", "", $write_data_stats_goalies);

	$file_tmp_data_stats_goalies = "tmp/tmp_data_stats_goalies_$yesterday.txt";
			$write_data_stats = StripSlashes($write_data_stats_goalies."\n");
			$fp_goalies = FOpen ($file_tmp_data_stats_goalies, "w");
			FWrite ($fp_goalies, $write_data_stats_goalies);
			FClose ($fp_goalies);
$ok2 = "ok";

}

if ($ok2 == "ok") {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=download_stats_pp.php\">";}
?>