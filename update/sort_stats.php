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
		<form action=\"sort_stats.php\" method=\"post\" name=\"form1\" onsubmit=\"return obfuscate()\">
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

echo "<br />goals:<br /><form name=\"write_stats_tmp\" method=\"post\"><textarea readonly=\"readonly\" class=\"list\" name=\"goals_sort_input\" cols=\"100\" rows=\"10\"/>";
$file = "tmp/tmp_points_".$type.$yesterday.".txt";
if(File_exists($file)) {
	$f_players = fopen($file,"r");
	while(!feof($f_players)) {
		$tmp_stats = explode("|", fgets($f_players,2000));
		if(($tmp_stats[0] !== "\n") && ($tmp_stats[0]!=="")) {
			$go = $tmp_stats[2] + 50;
			$po = $tmp_stats[4] + 50;
			if ($tmp_stats[2] !== "0") {$perc = number_format(($tmp_stats[7] / $tmp_stats [2])*100, 2)+100;} else {$perc = 100;}
			
			$goals = $go.";".$po.";".$perc.";".$tmp_stats[0]."|".$tmp_stats[1]."|".$tmp_stats[2]."|".$tmp_stats[3]."|".$tmp_stats[4]."|".$tmp_stats[5]."|".$tmp_stats[6]."|".$tmp_stats[7]."|".$tmp_stats[8]."|".$tmp_stats[9]."|".$tmp_stats[10]."|".$tmp_stats[11]."|".$tmp_stats[12]."|".$tmp_stats[13]."|".$tmp_stats[14]."|".$tmp_stats[15]."\n";	
			$goals_sort[] = $goals; 
		}
	}fclose($f_players);
		
	arsort($goals_sort);
	$z = 1;
	foreach ($goals_sort as $goals) {
		$tmp_goals_sorted = explode(";",$goals);
		echo $z."||".$tmp_goals_sorted[3];$z++;
	}
} else {echo "no data for $yesterday";}
echo "</textarea><br />";

echo "<br />points:<br /><textarea readonly=\"readonly\" class=\"list\" name=\"points_sort_input\" cols=\"100\" rows=\"5\"/>";
$file = "tmp/tmp_points_".$type.$yesterday.".txt";
if(File_exists($file)) {
	$f_players = fopen($file,"r");
	while(!feof($f_players)) {
		$tmp_stats = explode("|", fgets($f_players,2000));
		if(($tmp_stats[0] !== "\n") && ($tmp_stats[0]!=="")) {
			$go = $tmp_stats[2] + 50;
			$po = $tmp_stats[4] + 50;
			$pe = $tmp_stats[6] + 50;
					
			$points = $po.";".$go.";".$pe.";".$tmp_stats[0]."|".$tmp_stats[1]."|".$tmp_stats[2]."|".$tmp_stats[3]."|".$tmp_stats[4]."|".$tmp_stats[5]."|".$tmp_stats[6]."|".$tmp_stats[7]."|".$tmp_stats[8]."|".$tmp_stats[9]."|".$tmp_stats[10]."|".$tmp_stats[11]."|".$tmp_stats[12]."|".$tmp_stats[13]."|".$tmp_stats[14]."|".$tmp_stats[15]."\n";	
			$points_sort[] = $points; 
		}
	}fclose($f_players);
		
	arsort($points_sort);
	$z = 1;
	foreach ($points_sort as $points) {
		$tmp_points_sorted = explode(";",$points);
		echo $z."||".$tmp_points_sorted[3];$z++;
	}
} else {echo "no data for $yesterday";}
echo "</textarea><br />";

echo "<br />defs:<br /><textarea readonly=\"readonly\" class=\"list\" name=\"defs_sort_input\" cols=\"100\" rows=\"5\"/>";
$file = "tmp/tmp_defs_".$type.$yesterday.".txt";
if(File_exists($file)) {
	$f_players = fopen($file,"r");
	while(!feof($f_players)) {
		$tmp_stats = explode("|", fgets($f_players,2000));
		if(($tmp_stats[0] !== "\n") && ($tmp_stats[0]!=="")) {
			$go = $tmp_stats[2] + 50;
			$po = $tmp_stats[4] + 50;
			$pe = $tmp_stats[6] + 50;
					
			$defs = $po.";".$go.";".$pe.";".$tmp_stats[0]."|".$tmp_stats[1]."|".$tmp_stats[2]."|".$tmp_stats[3]."|".$tmp_stats[4]."|".$tmp_stats[5]."|".$tmp_stats[6]."|".$tmp_stats[7]."|".$tmp_stats[8]."|".$tmp_stats[9]."|".$tmp_stats[10]."|".$tmp_stats[11]."|".$tmp_stats[12]."|".$tmp_stats[13]."|".$tmp_stats[14]."|".$tmp_stats[15]."\n";	
			$defs_sort[] = $defs; 
		}
	}fclose($f_players);
		
	arsort($defs_sort);
	$z = 1;
	foreach ($defs_sort as $defs) {
		$tmp_defs_sorted = explode(";",$defs);
		echo $z."||".$tmp_defs_sorted[3];$z++;
	}
} else {echo "no data for $yesterday";}
echo "</textarea><br />";


echo "<br />goalies:<br /><textarea readonly=\"readonly\" class=\"list\" name=\"goalies_sort_input\" cols=\"100\" rows=\"5\"/>";
$file = "tmp/tmp_goalies_".$type.$yesterday.".txt";
if(File_exists($file)) {
	$f_players = fopen($file,"r");
	while(!feof($f_players)) {
		$tmp_stats = explode("|", fgets($f_players,2000));
		if(($tmp_stats[0] !== "\n") && ($tmp_stats[0]!=="")) {
			$pc = ($tmp_stats[4] + 100)*100;
			$sh = $tmp_stats[2] + 100;
			$so = $tmp_stats[5] + 10;
				
			$match = $tmp_stats[1];
			$matches[] = $match; 	
			$goalies = $pc.";".$sh.";".$so.";".$tmp_stats[0]."|".$tmp_stats[1]."|".$tmp_stats[2]."|".$tmp_stats[3]."|".$tmp_stats[4]."|".$tmp_stats[5]."|".$tmp_stats[6]."|".$tmp_stats[7]."|".$tmp_stats[8]."|".$tmp_stats[9]."|".$tmp_stats[10]."|".$tmp_stats[11]."|\n";
				
			$goalies_sort[] = $goalies; 
		}
	}fclose($f_players);
	if($type == "reg") {	
		$max = max($matches)/2;
			
		arsort($goalies_sort);
		$z = 1;
		foreach ($goalies_sort as $goalies) {
			$tmp_goalies_sorted = explode(";",$goalies);
			$tmp_match = explode ("|",$tmp_goalies_sorted[3]);
			if ($tmp_match[10] > $max*60) {echo $z."||".$tmp_goalies_sorted[3];$z++;}
		}
		foreach ($goalies_sort as $goalies) {
			$tmp_goalies_sorted = explode(";",$goalies);
			$tmp_match = explode ("|",$tmp_goalies_sorted[3]);
			if ($tmp_match[10] <= $max*60) {echo "-||".$tmp_goalies_sorted[3];}
		}
	}
	elseif($type == "po") {
	   if(max($matches) > 1) {
		arsort($goalies_sort);
		$z = 1;
		foreach ($goalies_sort as $goalies) {
			$tmp_goalies_sorted = explode(";",$goalies);
			$tmp_match = explode ("|",$tmp_goalies_sorted[3]);
			if ($tmp_match[10] > 59) {echo $z."||".$tmp_goalies_sorted[3];$z++;}
		}
		foreach ($goalies_sort as $goalies) {
			$tmp_goalies_sorted = explode(";",$goalies);
			$tmp_match = explode ("|",$tmp_goalies_sorted[3]);
			if ($tmp_match[10] <= 59) {echo "-||".$tmp_goalies_sorted[3];}
		}
	   }
	   else {
	   $z = 1;
        arsort($goalies_sort);
		foreach ($goalies_sort as $goalies) {
			$tmp_goalies_sorted = explode(";",$goalies);
			$tmp_match = explode ("|",$tmp_goalies_sorted[3]);
			echo $z."||".$tmp_goalies_sorted[3];$z++;
		}
		}
    }
}
echo "</textarea><br />";



echo "<br /><input type=\"hidden\" name=\"ok\" value=\"ok\"><input type=\"hidden\" name=\"ok1\" value=\"ok\">\nwrite stats --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\"/>\n</form><br />";
}

if (($ok1 == "ok") && ($ok == "ok")) {


$file_goals = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/stats/goals".$current_season.$type.".txt";
		$write_goals = StripSlashes($goals_sort_input."\n");
				$fp = FOpen ($file_goals, "w");
				FWrite ($fp, $write_goals);
				FClose ($fp); 

$file_points = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/stats/points".$current_season.$type.".txt";
		$write_points = StripSlashes($points_sort_input."\n");
				$fp = FOpen ($file_points, "w");
				FWrite ($fp, $write_points);
				FClose ($fp); 


$file_defs = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/stats/defs".$current_season.$type.".txt";
		$write_defs = StripSlashes($defs_sort_input."\n");
				$fp = FOpen ($file_defs, "w");
				FWrite ($fp, $write_defs);
				FClose ($fp); 
				

$file_goalies = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/stats/goalies".$current_season.$type.".txt";
		$write_goalies = StripSlashes($goalies_sort_input."\n");
				$fp = FOpen ($file_goalies, "w");
				FWrite ($fp, $write_goalies);
				FClose ($fp);
$update_file = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/data/update".$current_season.".txt";
    if (File_exists($update_file)) {
		$old_update_file = FOpen($update_file, "r");
		$data_old_update_file = FRead ($old_update_file, filesize($update_file));
	fclose($old_update_file);}
    $update_text = time()."|stats|stats|\n";
	$yes_update_file = FOpen ($update_file, "w");
	FWrite ($yes_update_file, $update_text.$data_old_update_file);
	Fclose ($yes_update_file);
     
echo "<br /><br />DONE!";
echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=upload.php\">";	
	}			
 
?>	





</div>
</body>
</html>