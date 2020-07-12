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
		<form action=\"sum_stats.php\" method=\"post\" name=\"form1\" onsubmit=\"return obfuscate()\">
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

//sum za hracov...
if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {$type = "po";} else {$type = "reg";}

if(!isset($process)) {$process = 1;}
if(!isset($session)) {$session = 1;}

if($session == 1) {$session_file = "points";} elseif($session == 2) {$session_file = "defs";} elseif ($session == 3) {$session_file = "goalies";} 

$file_write_players = "tmp/points".$current_season.$type.$yesterday."_stars.txt";
$file_write_stats_round_players_new = "tmp/points".$current_season.$type.$yesterday."_new_pp.txt";

if(file_exists($file_write_players)) {
    	$size = file($file_write_players);
        $max_count = 850;
    	$count_file = Ceil((Count($size))/$max_count);
    
    
    $f_players = fopen($file_write_players,"r");

    
    
    $start = 0+$max_count*$process-$max_count; 
    
    if($process == $count_file) 
    {$end = count($size);} 
    else {$end = $max_count*$process-1;}
    
    echo "write current round";
    echo "<center><br /><br /><form name=\"write_stats_tmp\" method=\"post\"><textarea readonly=\"readonly\" class=\"list\" name=\"write_stats_tmp\" cols=\"100\" rows=\"40\"/>";
    if (($session == "1") || ($session == "2")) {
    	for($i=$start;$i<=$end;$i++) {
            $ppg = 0;
            $shg = 0;
            $pim = 0;
            $usg = 0;
    		$tmp_player = explode("|", $size[$i]);
    		if($tmp_player[0] !== "") {
    		  $name = $tmp_player[2];
    				$f = fopen($file_write_stats_round_players_new,"r");
    				while(!feof($f)) {
    					$tmp_stats = explode("|",fgets($f,2000));
    					if ((trim($tmp_stats[0]) !== "")) {
    						$hlp_name = trim($tmp_stats[2])."-".trim($tmp_stats[12]);
    						if(trim($tmp_player[1]) == ($hlp_name)){
    						  	
                                $team = $tmp_stats[11];
                                $team_short = $tmp_stats[12];
                                $ppg = $ppg + $tmp_stats[14];
                                $shg = $shg + $tmp_stats[15];
                                $pim = $pim + $tmp_stats[16];
                                $usg = $usg + $tmp_stats[17];
    						}
    					}
    			}fclose($f);
                
    			$player = $tmp_player[1];
    			$go[$player] = $tmp_player[4];
    			$as[$player] = $tmp_player[5];
    			$po[$player] = $tmp_player[6];
    			$pm[$player] = $tmp_player[7];
    			$ma[$player] = $tmp_player[3];
    			$sh[$player] = $tmp_player[9];
    			$pe[$player] = $tmp_player[8];
    			$te[$player] = $tmp_player[11];
    			$t_s[$player] = $tmp_player[12];
    			$id_p[$player] = $tmp_player[13];
    			$pp_p[$player] = $ppg;
                $sh_p[$player] = $shg;
                $pim_p[$player] = $pim;
                $usg_p[$player] = $usg;
                $team2[$player] = $tmp_player[14];
    	        $u = $i + 1;
    			$player_line = $u."|".($name)."|".trim($ma[$player])."|".trim($go[$player])."|".trim($as[$player])."|".trim($po[$player])."|".trim($pm[$player])."|".trim($pe[$player])."|".trim($sh[$player])."||".trim($te[$player])."|".trim($t_s[$player])."|".trim($id_p[$player])."|".$pp_p[$player]."|".$sh_p[$player]."|".$pim_p[$player]."|".$usg_p[$player]."|".$team2[$player]."|".$yesterday."|\n";
    			if (($ma[$player] !== 0) && ($ma[$player] != "")) {echo $player_line;}
    			}
    		}fclose($f_players);
    }


    if($process < $count_file)  {$process = $process + 1;
    	echo "</textarea>\n<br /><br /><input type=\"hidden\" name=\"process\" value=\"$process\">\n<input type=\"hidden\" name=\"session\" value=\"$session\">\nwrite current round --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\"/>\n</form><br />";}
    elseif ($process == $count_file) {
    	if ($ok !== "ok") {echo "</textarea>\n<br /><br /><input type=\"hidden\" name=\"process\" value=\"$process\">\n<input type=\"hidden\" name=\"ok\" value=\"ok\">\nwrite players stats unsorted --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\"/>\n</form><br />";}
    	elseif (($ok == "ok") && ($session !== "3")) {$session = $session+1; echo "</textarea></form><br />\n<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sum_stats.php\">"; }
    	elseif (($ok == "ok") && ($session == "3" )) {
    		echo "</textarea></form>\n<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sort_stats.php\">";
    	}
}

}


$file = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/stats/points_round".$current_season.".txt";
$file_old = "tmp/points_round".$current_season."_".$yesterday.".txt";
		
		$write = StripSlashes($write_stats_tmp."\n");
			if ((File_Exists($file_old)) || (Count(File($file_old))!==0)) {
				$fp = FOpen ($file_old, "r");
				$data = FRead ($fp, FileSize($file_old));
				FClose($fp);
			}		
		
				$fp = FOpen ($file, "w");
				FWrite ($fp, $write.$data);
				FClose ($fp); 

                
$file_goalies = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/stats/goalies_round".$current_season.".txt";
$file_old_goalies = "tmp/goalies_round".$current_season."_".$yesterday.".txt";
$file_new_goalies = "tmp/goalies".$current_season.$type.$yesterday."_stars.txt";
		
		
			if ((File_Exists($file_old_goalies)) || (Count(File($file_old_goalies))!=0)) {
				$fp_goalies = FOpen ($file_old_goalies, "r");
				$data_goalies = FRead ($fp_goalies, FileSize($file_old_goalies));
				FClose($fp_goalies); }
            if ((File_Exists($file_new_goalies)) || (Count(File($file_new_goalies))!=0)) {
				$fp_goalies_new = FOpen ($file_new_goalies, "r");
				$write_goalies = FRead ($fp_goalies_new, FileSize($file_new_goalies));
				FClose($fp_goalies_new); 
			}				
		
				$fp = FOpen ($file_goalies, "w");
				FWrite ($fp, $write_goalies.$data_goalies);
				FClose ($fp); 
        

?>	





</div>
</body>
</html>