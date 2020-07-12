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
		<form action=\"login_teams_details.php\" method=\"post\" name=\"form1\" onsubmit=\"return obfuscate()\">
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


echo "<center>Results downloaded<p></center>";



//$file = "teams.txt";
	

include ($_SERVER['DOCUMENT_ROOT']."/stanleycup/settings.php");




$teams_list = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/teams/teams.txt";

if($ok !="ok") {
    
    echo "<center><form name=\"write_teams\" method=\"post\"><textarea readonly=\"readonly\" class=\"list\" name=\"write_teams\" cols=\"130\" rows=\"40\"/>";
    
    $f = fopen($teams_list,"r");
    	while(!feof($f)) {
    		$tmp = explode("|",fgets($f,2000));
    		if ((trim($tmp[0]) != "") && ($tmp[0] !="atl") /*&& (($tmp[0]=="ana") || ($tmp[0]=="bos"))*/) {
    			$team_short = $tmp[0];
                $team_id = $tmp[3];
    			include("update_settings.php");
    			
    			$link = "$prefix/index.php?p=public_team_info_basic.php&team_id=$team_id";
    			
    			
    			curl_setopt($ch, CURLOPT_URL, $link);
    			$result = curl_exec ($ch);
    			curl_close ($ch); 
    			$read = $result;
    			
    			
    			// this gets rid of most of the CSS in the page
    			$read = preg_replace("/<head>(.*)<\/select>/ism","",$read);
    			$read = preg_replace("/(.*)<!-- end sidebarleft -->/ism","",$read);
    			$read = preg_replace("/<!-- begin sidebar -->(.*)/ism","",$read);
                $read_stats = preg_replace("/(.*)tatistiky/ism","",$read);
    
                $read_sila = preg_replace("/asistenti(.*)/ism","",$read);
                $read_sila = preg_replace("/(.*)Kapacita/ism","",$read);
                $read_sila = strip_tags($read_sila);
                $read_sila = preg_replace("/\\n/","",$read_sila);
    			$read_sila = preg_replace("/\\t/","",$read_sila);
    			$read_sila = trim($read_sila);
    			$read_sila = str_replace("&nbsp;", "|", $read_sila);
                $read_sila = str_replace("      ", "|", $read_sila);
    			$read_sila = str_replace("||", "|", $read_sila);
    			$read_sila = str_replace("||", "|", $read_sila);
    			$read_sila = str_replace("|    |", "|", $read_sila);
    			$read_sila = str_replace("   ", "|", $read_sila);
                $read_sila = str_replace(" ", "|", $read_sila);
    			$read_sila = str_replace("|||", "|", $read_sila);
                $read_sila = str_replace("|Disable-","",$read_sila);
                $read_sila = str_replace("-|Multiplayer-|Scouting-","",$read_sila);
                
                
                $read_kapitan = preg_replace("/(.*)<table class=\"stats\" width=\"100%\">/ism","",$read);
                
                $read_kapitan = strip_tags($read_kapitan);
    			$read_kapitan = preg_replace("/\\n/","",$read_kapitan);
    			$read_kapitan = preg_replace("/\\t/","",$read_kapitan);
    			$read_kapitan = trim($read_kapitan);
    			$read_kapitan = str_replace("&nbsp;", "|", $read_kapitan);
                $read_kapitan = str_replace("      ", "|", $read_kapitan);
    			$read_kapitan = str_replace("|    ", "|", $read_kapitan);
    			$read_kapitan = str_replace("||", "|", $read_kapitan);
                $read_kapitan = str_replace("|||", "|", $read_kapitan);
                $read_kapitan = str_replace("|||", "|", $read_kapitan);
    
                $read_stats = strip_tags($read_stats);
    			$read_stats = preg_replace("/\\n/","",$read_stats);
    			$read_stats = preg_replace("/\\t/","",$read_stats);
    			$read_stats = trim($read_stats);
    			$read_stats = str_replace("&nbsp;", "|", $read_stats);
                $read_stats = str_replace("      ", "|", $read_stats);
    			$read_stats = str_replace("||", "|", $read_stats);
    			$read_stats = str_replace("||", "|", $read_stats);
    			$read_stats = str_replace("|    |", "|", $read_stats);
    			$read_stats = str_replace("   ", "|", $read_stats);
                $read_stats = str_replace(" ", "|", $read_stats);
    			$read_stats = str_replace("|||", "|", $read_stats);
    
                //echo $read_kapitan."\n\n**********************\n\n";
                $tmp_kapitan = explode ("|",$read_kapitan);
                if ((!isset($tmp_kapitan[12]) && ($tmp_kapitan[5] != "")) && ($tmp_kapitan[5] != "???")) {$kapitan = $tmp_kapitan[5];} else {$kapitan = "-";}   
                if ((!isset($tmp_kapitan[12]) && ($tmp_kapitan[6] != "")) && ($tmp_kapitan[6] != "???")) {$as1 = $tmp_kapitan[6];} else {$as1 ="-";}  
                if ((!isset($tmp_kapitan[12]) && ($tmp_kapitan[7] != "")) && ($tmp_kapitan[7] != "???")) {$as2 = $tmp_kapitan[7];} else {$as2="-";}
                
    			$tmp_read = explode ("|",$read_sila);
                $tmp_read_stats = explode ("|",$read_stats);
    //echo "team_short|kapacita stadiona|brana|obrana|utok|strelba|nahravka|skusenost|forma|kapitan|asistent|asistent|IS22|age22|IS17|is22\n\n\n";
    echo $team_short."|".$tmp_read[1]."|".preg_replace('/[^0-9.]/s', '', $tmp_read[7])."|".preg_replace('/[^0-9.]/s', '', $tmp_read[8])."|".preg_replace('/[^0-9.]/s', '', $tmp_read[9])."|".preg_replace('/[^0-9.]/s', '', $tmp_read[12])."|".preg_replace('/[^0-9.]/s', '', $tmp_read[13])."|".preg_replace('/[^0-9.]/s', '', $tmp_read[16])."|".preg_replace('/[^0-9.]/s', '', $tmp_read[17])."|".$kapitan."|".$as1."|".$as2."|".$tmp_read_stats[4]."|".$tmp_read_stats[14]."|".$tmp_read_stats[9]."|".$tmp_read_stats[19]."|".$tmp[2]."|";
    
    
    
    
                
    
        }
    }
    fclose($f);
    
    
    echo "</textarea>\n<br /><input type=\"hidden\" name=\"ok\" value=\"ok\"><input type=\"hidden\" name=\"ok1\" value=\"ok\"><br />\n write results --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\" />\n</form>";
}

if ($ok == "ok") {
	$file_teams = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/teams/teams_details.txt";
	
			$write_teaams = StripSlashes($write_teams."\n");
			$fp_teams = FOpen ($file_teams, "w");
			FWrite ($fp_teams, $write_teams);
			FClose ($fp_teams);
	$update_file = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/data/update".$current_season.".txt";
    if (File_exists($update_file)) {
		$old_update_file = FOpen($update_file, "r");
		$data_old_update_file = FRead ($old_update_file, filesize($update_file));
	fclose($old_update_file);}
    $update_text = time()."|teams details|teams_addinfo|\n";
	$yes_update_file = FOpen ($update_file, "w");
	FWrite ($yes_update_file, $update_text.$data_old_update_file);
	Fclose ($yes_update_file);
    
    		
	$done = "done";	
	echo "<center><br />done!<center>";
	
if($done == "done") {
	
	
	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=upload.php\">";}
}
?>
</div>
</body>
</html>