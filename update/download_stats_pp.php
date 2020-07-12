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
                $team_1_short = $tmp[8];
                $team_2_short = $tmp[9];
                $team_1_long = $tmp[1];
                $team_2_long = $tmp[2];
                
    			include("update_settings.php");
    			$link = "$prefix/index.php?p=public_match_info.php&match_id=$id_match";
    			
    			curl_setopt($ch, CURLOPT_URL, $link);
    			$result = curl_exec ($ch);
    			curl_close ($ch); 
    			$read = $result;
    			
    			
    			// this gets rid of most of the CSS in the page
    			$read = preg_replace("/<head>(.*)<\/select>/ism","",$read);
    			$read = preg_replace("/(.*)<\/ul>/ism","",$read);
    			$read = str_replace("Toronto Maple Leafs&nbsp;®", "Toronto Maple Leafs ®", $read);
                $read_team_stats = $read; 
    			$readgame = $read;
                $readincome = $read;
    			$read = preg_replace("/<div(.*)<table width=\"100%\" style=\'font-size: 100%;\'><tr><td align=\'center\' valign=\"top\">/ism","",$read);
    			
    
    			$read_total = preg_replace("/<table width=\"500\">(.*)/ism","",$read);
    
    			$read_team1 = preg_replace("/<\/table>(.*)/ism","",$read_total);
    			$read_team2 = preg_replace("/(.*)<table width=\"355\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">/ism","",$read_total);
    			$read_team1 = preg_replace("/<table width=\"355\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">/","",$read_team1);
    			$read_team_name1 = preg_replace("/<tr class=\"ysptblthbody1\" align=\"right\">(.*)/ism","",$read_total);
    			$read_team_name1 = strip_tags($read_team_name1);
    			$read_team_name1 = trim($read_team_name1);
    			if(strstr(($read_team_name1),"Toronto")) {$read_team_name1 = "Toronto Maple Leafs";}
    			$read_team_name1 = str_replace ("\\n","",$read_team_name1);
    			$read_team_name2 = preg_replace("/<tr class=\"ysptblthbody1\" align=\"right\">(.*)/ism","",$read_team2);
    			$read_team_name2 = strip_tags($read_team_name2);
    			$read_team_name2 = trim($read_team_name2);
    			if(strstr(($read_team_name2),"Toronto")) {$read_team_name2 = "Toronto Maple Leafs";}
    			$read_team_name2 = str_replace ("\\n","",$read_team_name2);
    			
                $readgame = preg_replace("/(.*)<table width=\"700\" border=\"0\" cellpadding=\"1\" cellspacing=\"0\">/ism","",$readgame);
                $readgame = preg_replace("/<hr noshade size='1'\/>(.*)/ism","",$readgame);
                $readgame = str_replace ("</td>","\n",$readgame);
                $readgame = str_replace ("<td class=\"nice\" style=\"color: #AA0000\" align=\"right\">",$read_team_name1."=PIM|",$readgame);
                $readgame = str_replace ("<td class=\"nice\" style=\"color: blue\" align=\"right\">",$read_team_name1."=GOAL|",$readgame);
                $readgame = str_replace ("<td class=\"nice\" style=\"color: #AA0000\" align=\"left\">",$read_team_name2."=PIM|",$readgame);
                $readgame = str_replace ("<td class=\"nice\" style=\"color: blue\" align=\"left\">",$read_team_name2."=GOAL|",$readgame);
                $readgame = str_replace ("<b>","--",$readgame);
                $readgame = str_replace ("<br>","--",$readgame);
                $readgame = str_replace ("</b>","!!",$readgame);
                $sub = preg_replace ("/Striedanie brank(..)ra/","|Striedanie",$readgame);
                $readgame = preg_replace ("/Striedanie brank(..)ra/","",$readgame);
                $readgame = preg_replace ("/Brank(..)r stratil sebad(..)veru a koncentr(..)ciu/","",$readgame);
                $readgame = preg_replace ("/(..):(..)\\n/","",$readgame);
                $readgame = str_replace ("<img src=\"http://www.hockeyarena.net/pics/target.gif\">", "*USG*", $readgame);
                $readgame = strip_tags($readgame);
                $readgame = str_replace ($read_team_name1."=GOAL|\n","",$readgame);
                $readgame = str_replace ($read_team_name1."=PIM|\n","",$readgame);
                $readgame = str_replace ($read_team_name2."=GOAL|\n","",$readgame);
                $readgame = str_replace ($read_team_name2."=PIM|\n","",$readgame);
                $readgame = str_replace ($read_team_name1."=GOAL|",$read_team_name1."=GOAL|".$read_team_name2."=G_ALLOWED|",$readgame);
                $readgame = str_replace ($read_team_name1."=PIM|",$read_team_name1."=PIM|".$read_team_name2."=POWERPLAY|",$readgame);
                $readgame = str_replace ($read_team_name2."=GOAL|",$read_team_name2."=GOAL|".$read_team_name1."=G_ALLOWED|",$readgame);
                $readgame = str_replace ($read_team_name2."=PIM|",$read_team_name2."=PIM|".$read_team_name1."=POWERPLAY|",$readgame);
                $readgame = trim($readgame);
                $readgame = preg_replace("/(.*)1. tretina:\\n/ism","",$readgame);
                $readgame = preg_replace ("/(.). tretina:\\n/","",$readgame);
                $readgame = preg_replace("/(.). pred(..)/","pred",$readgame);
                $readgame = preg_replace("/pred(..)enie:\\n/","",$readgame);
                $readgame = str_replace ("&nbsp;","",$readgame);
                $sub = strip_tags($sub);
                $sub = preg_replace ("/(.). tretina:\\n/","",$sub);
                //$sub = str_replace ("&nbsp;","",$sub);
                
                $sub1 = str_replace ("\n".$read_team_name1."=PIM||Striedanie\n","XXX".$read_team_name1."=Striedanie1|",$sub);
                $sub2 = str_replace ("\n".$read_team_name2."=PIM||Striedanie","|".$read_team_name2."=Striedanie2\n",$sub);
                
                $sub1 = preg_replace ("/(.*)XXX/ism","",$sub1);
                $sub1 = preg_replace ("/\\n(.*)/ism","",$sub1);
                $sub1 = str_replace ("Striedanie1","Striedanie",$sub1);
                
                $sub2 = preg_replace ("/Striedanie2(.*)/ism","Striedanie",$sub2);
                $sub1 = preg_replace ("/\\n&nbsp;/","|",$sub1);
                $sub1 = preg_replace ("/(.*)\\n/","\n",$sub1);
                $sub2 = preg_replace ("/(.*)\\n/","\n",$sub2);
                $sub1 = str_replace ("\n".$read_team_name2."=Striedanie","",$sub1);
                $sub2 = str_replace ("\n".$read_team_name1."=Striedanie","",$sub2);
                $sub1 = str_replace ("\n\n","",$sub1);
                $sub2 = str_replace ("\n\n","",$sub2);
                
                //$read_team2 = iconv('Utf-8', 'Windows-1250', $read_team2);
    			
    			//$read = strip_tags($read);
    			
    			//echo $read_team_name1;
    			
    			//echo $read_team_name2;
                
                
                $read_team_stats = preg_replace("/(.*)>Vyhr<\/td>/ism","",$read_team_stats);
    			$read_team_stats = preg_replace("/<table width=\"100%\" style=\'font-size: 100%;\'>(.*)/ism","",$read_team_stats);
                $read_team_stats = str_replace("\n","",$read_team_stats);
                $read_team_stats = str_replace("</td>","|",$read_team_stats);
                $read_team_stats = str_replace("</tr>","|==|",$read_team_stats);
                $read_team_stats = strip_tags($read_team_stats);
    			$read_team_stats = trim($read_team_stats);
                $read_team_stats = str_replace("                ","",$read_team_stats);
                $read_team_stats = str_replace("     ","",$read_team_stats);
                $read_team_stats = str_replace("    ","",$read_team_stats);
                $read_team_stats = str_replace("|   ","|",$read_team_stats);
                $read_team_stats = str_replace("&nbsp;","",$read_team_stats);
                $read_team_stats = trim($read_team_stats);
                
                
                $readincome = preg_replace("/(.*)<div id=\"page\">/ism","",$readincome);
                
                $readincome = preg_replace("/(.*)<td width='20%' class='center' style='white-space:nowrap;'>/ism","",$readincome);
                $readincome = preg_replace("/<td width='70' class='center' style='font-size: 40px; font-weight: bold; padding:10px 0 10px;'>(.*)/ism","",$readincome);
                $readincome = str_replace("\n","",$readincome);
                $readincome = trim($readincome);
                $readincome = str_replace("      ","",$readincome);
                $readincome1 = preg_replace("/(.*)et div/ism","",$readincome);
                $readincome1 = preg_replace("/<br(.*)/ism","",$readincome1);
                $readincome1 = preg_replace("/(.*) : /ism","",$readincome1);
                $readincome2 = preg_replace("/(.*)et div/ism","",$readincome);
                $readincome2 = preg_replace("/(.*)pasu : /ism","",$readincome2);
                $readincome2 = str_replace("  </td>","",$readincome2);
                $readincome2 = str_replace(" ","",$readincome2);
                $readincome3 = preg_replace("/(.*)vstupenky : /ism","",$readincome);
                $readincome3 = preg_replace("/<br(.*)/ism","",$readincome3);
                $read_team_name1 = str_replace("  ", " ", $read_team_name1);
                $home_team = "";
                if(strstr(trim($read_team_name1),trim($team_1_long))) {$home_team = $team_1_short;}
                if(strstr(trim($read_team_name1),trim($team_2_long))) {$home_team = $team_2_short;}
                if(strstr(trim($team_1_long), trim($read_team_name1))) {$home_team = $team_1_short;}
                if(strstr(trim($team_2_long), trim($read_team_name1))) {$home_team = $team_2_short;}
    
                
                
                $read_income = $id_match."|".$readincome1."|".$readincome2."|".$readincome3."|".$team_1_short."|".$team_2_short."|".trim($read_team_name1)."|".trim($read_team_name2)."|".$tmp[5]."|".$tmp[6]."|".$tmp[7]."|".$home_team."|";
                
                
                
                //$read_team_stats = preg_replace("/|  |==|(.*)/ism","",$read_team_stats);
                //$read_team_stats1 = preg_replace("/(.*)|  |==|/ism","",$read_team_stats);
                //$read_team_stats = $read_team_stats1.$read_team_stats2;
                                
    			$data_goalies1[] = $read_goalies_team1;
    			
    			$data_goalies2[] = $read_goalies_team2;
    			
    			$data_team1[] = $readgame;
    			
    			$data_team2[] = $sub1."\n".$sub2."\n";
                $data_teamstats[] = $read_team_stats;
                $data_incomes[] = $read_income;
                
    			}
    		}
    	}
    	
    
    echo "<form name=\"write_data_stats\" method=\"post\"><textarea readonly=\"readonly\" class=\"list\" name=\"write_data_stats\" cols=\"100\" rows=\"5\" >";
    foreach ($data_team1 as $read_team1) {
    	echo $read_team1."\n";
    }
    
    echo "</textarea>";//readonly=\"readonly\"
    echo "<br /><textarea  class=\"list\" name=\"write_data_stats_goalies\" cols=\"100\" rows=\"5\" >";
    foreach ($data_team2 as $read_team2) {
    	echo $read_team2."\n";
    }
    /*foreach ($data_goalies2 as $read_goalies_team2) {
    	echo $read_goalies_team2."\n";
    }*/
    echo "</textarea>";
    echo "<br /><textarea  class=\"list\" name=\"write_data_teams_stats\" cols=\"100\" rows=\"5\" >";
    foreach ($data_teamstats as $read_teamstats) {
    	echo $read_teamstats."\n";
    }
    /*foreach ($data_goalies2 as $read_goalies_team2) {
    	echo $read_goalies_team2."\n";
    }*/
    echo "</textarea>";
    echo "<br /><textarea  class=\"list\" name=\"write_data_game_income\" cols=\"100\" rows=\"5\" >";
    foreach ($data_incomes as $read_income) {
    	echo $read_income."\n";
    }
    /*foreach ($data_goalies2 as $read_goalies_team2) {
    	echo $read_goalies_team2."\n";
    }*/
    echo "</textarea>";
    
    //echo $readgame;
    
    echo "\n<br /><input type=\"hidden\" name=\"ok1\" value=\"ok\">\n<br />write data --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\" />\n</form><br />";

}
$yesterday = date("d.m.Y", $tmp_yesterday);	
	
	
if ($ok1 == "ok") {
	$write_data_stats = str_replace("&nbsp;", "", $write_data_stats);
	//$write_data_stats = str_replace("Toronto Maple Leafs&nbsp;®", "Toronto Maple Leafs ®", $write_data_stats);//toto aj tak nefunguje (asi)...
	//$write_data_stats = iconv('Utf-8', 'Windows-1250', $write_data_stats);

    
	$file_tmp_data_stats = "tmp/tmp_data_stats_pp_$yesterday.txt";
			$write_data_stats = StripSlashes($write_data_stats."\n");
			$fp = FOpen ($file_tmp_data_stats, "w");
			FWrite ($fp, $write_data_stats);
			FClose ($fp);

	$write_data_stats_goalies = str_replace("&nbsp;", "", $write_data_stats_goalies);

	$file_tmp_data_stats_goalies = "tmp/tmp_data_stats_goalies_sub_$yesterday.txt";
			$write_data_stats_goalies = StripSlashes($write_data_stats_goalies."\n");
			$fp_goalies = FOpen ($file_tmp_data_stats_goalies, "w");
			FWrite ($fp_goalies, $write_data_stats_goalies);
			FClose ($fp_goalies);

	$file_tmp_teams_stats = "tmp/tmp_data_teams_stats_$yesterday.txt";
			$write_data_teams_stats = StripSlashes($write_data_teams_stats."\n");
			$fp_teams_stats = FOpen ($file_tmp_teams_stats, "w");
			FWrite ($fp_teams_stats, $write_data_teams_stats);
			FClose ($fp_teams_stats);
            
    $file_write_round_income = "tmp/income".$current_season."_".$yesterday.".txt";
    if (!file_exists($file_write_stats_round_teamsstats)) {
       	$file_income = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/income".$current_season.".txt";
        $file_income_old = "tmp/income".$current_season."_$yesterday.txt";
        if(File_exists ($file_income_old)) {
            $old_income = FOpen($file_income_old, "r");
			$data_old_income = FRead ($old_income, filesize($file_income_old));
        }
    	elseif (File_exists($file_income)) {
			$old_income = FOpen($file_income, "r");
			$data_old_income = FRead ($old_income, filesize($file_income));
            fclose($old_income);
        }
			$write_data_income = StripSlashes($write_data_game_income."\n");
            $fp_income_old = Fopen ($file_income_old, "w");
            FWrite ($fp_income_old, $data_old_income);
            FClose ($fp_income_old);
			$fp_income = FOpen ($file_income, "w");
			FWrite ($fp_income, $data_old_income.$write_data_income);
			FClose ($fp_income);
    }
	$file_write_teamsstats_round_old = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/stats/teams".$current_season.".txt";
	$file_write_stats_round_teamsstats = "tmp/teams".$current_season."_".$yesterday.".txt";
	
	if (!file_exists($file_write_stats_round_teamsstats)) {
		if (File_exists($file_write_teamsstats_round_old)) {
			$old = FOpen($file_write_teamsstats_round_old, "r");
			$data_old = FRead ($old, filesize($file_write_teamsstats_round_old));
		fclose($old);}
		$yes = FOpen ($file_write_stats_round_teamsstats, "w");
		FWrite ($yes, $data_old);
		Fclose ($yes);
	}


$ok2 = "ok";

}

if ($ok2 == "ok") {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=count_stats.php\">";}
?>