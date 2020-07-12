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
if(!isset($process)) {$process = 1;}

include("update_date.php");
//$tmp_yesterday  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
$yesterday = date("d.m.Y", $tmp_yesterday);	

//sum pp

if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {$type = "po";} else {$type = "reg";}
	
$file_write_stats_round_players_pp = "tmp/points".$current_season.$type.$yesterday."_pp.txt";
$stats_file_tmp = "tmp/tmp_data_stats_pp_$yesterday.txt";


$size = file($file_write_stats_round_players_pp);
$count_file = Ceil((Count($size))/300);
$start = 0+300*$process-300; 

$f_players = fopen($file_write_stats_round_players_pp,"r");

if($process == $count_file) 
{$end = count($size);} 
else {$end = 300*$process-1;}

echo "step ".$process." of ".$count_file;

echo "<center><br /><br /><form name=\"write_stats_tmp\" method=\"post\"><textarea readonly=\"readonly\" class=\"list\" name=\"write_stats_tmp\" cols=\"100\" rows=\"40\"/>";

	for($i=$start;$i<=$end;$i++) {
		$tmp_player1 = explode("|", $size[$i]);
        if($tmp_player1[0] != "") {
		      $player_name = $tmp_player1[0]."-".$tmp_player1[1];
              
				$f = fopen($stats_file_tmp,"r");
				$pp = 0;
				$sh = 0;
				$pim = 0;
				$usg = 0;
				while(!feof($f)) {
				    $tmp = explode("|",fgets($f,2000));
                    $tmp_2 = explode("=", $tmp[0]);
        			$tmp_hlp = explode(";",$tmp[2]);
        			$tmp_player = explode("--", $tmp[2]);
                    $tmp_player2 = explode(" -", $tmp_player[1]);
                    $hlp_player = trim($tmp_player2[0])."-".trim($tmp_2[0]);
                    if ((trim($tmp[0]) !== "")) {
						if(trim($player_name) == ($hlp_player)){
							$name = $tmp_player1[0];
							$team = $tmp_player1[2];
							$team_short = $tmp_player1[3];
                            if(strstr(($tmp[0]),"PIM")) {$pim = $pim + 2;}
                            if(strstr(($tmp[2]),"--SH")) {$sh = $sh + 1;}
                            if(strstr(($tmp[2]),"--PP")) {$pp = $pp + 1;}
                            if(strstr(($tmp[2]),"*USG*")) {$usg = $usg + 1;}
                            
						}
					}
			}fclose($f);
			$player = $tmp_player1[0];
			$pp = $pp;
            $sh = $sh;
            $pim = $pim;
            $usg = $usg;
			$te = $team;
			$t_s = $team_short;
	
			$player_line = "X|".trim($name)."-".trim($t_s)."|".trim($name)."|||||||||".trim($te)."|".trim($t_s)."||".$pp."|".$sh."|".$pim."|".$usg."|\n";
			echo $player_line;
			}
		}fclose($f_players);

	
if($process < $count_file)  {$process = $process + 1;
	echo "</textarea>\n<br /<br /><br />\n<input type=\"hidden\" name=\"process\" value=\"$process\">\n<input type=\"hidden\" name=\"ok3\" value=\"ok\">\ncreate list of players --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\" />\n</form><br />";}	
elseif ($process == $count_file) {
	if ($ok !== "ok") {echo "</textarea>\n<br /><br /><input type=\"hidden\" name=\"process\" value=\"$process\">\n<input type=\"hidden\" name=\"ok\" value=\"ok\">\nwrite players stats unsorted --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\"/>\n</form><br />";}
	elseif (($ok == "ok")) {
		echo "</textarea></form>\n<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sum_stats_round.php\">";
	}
}
 
if(($ok3 == "ok")||( $ok== "ok")) {
 
			$file_write_stats_round_players_new = "tmp/points".$current_season.$type.$yesterday."_new.txt";
			$write_write_stats_round_players = StripSlashes($write_stats_tmp);
			
			if ((File_Exists($file_write_stats_round_players_new)) && (Count(File($file_write_stats_round_players_new))!==0)) {
				$fp_write_stats_round_players = FOpen ($file_write_stats_round_players_new, "r");
				$data_write_stats_round_players = FRead ($fp_write_stats_round_players, FileSize($file_write_stats_round_players_new));
				FClose($fp_write_stats_round_players); }
		
            
    			$fp_write_stats_round_players = FOpen ($file_write_stats_round_players_new, "w");
    			FWrite ($fp_write_stats_round_players, $write_write_stats_round_players.$data_write_stats_round_players);
    			FClose ($fp_write_stats_round_players);
			
            
            $file_write_stats_round_players_new_pp = "tmp/points".$current_season.$type.$yesterday."_new_pp.txt";
			$write_write_stats_round_players_pp = StripSlashes($write_stats_tmp);
			
    			$fp_write_stats_round_players_pp = FOpen ($file_write_stats_round_players_new_pp, "w");
    			FWrite ($fp_write_stats_round_players_pp, $write_write_stats_round_players_pp);
    			FClose ($fp_write_stats_round_players_pp);
                
                                
			$file_write_stats_round_defs_new = "tmp/defs".$current_season.$type.$yesterday."_new.txt";
			$write_write_stats_round_defs = StripSlashes($write_stats_tmp);

			if ((File_Exists($file_write_stats_round_defs_new)) && (Count(File($file_write_stats_round_defs_new))!==0)) {
				$fp_write_stats_round_defs = FOpen ($file_write_stats_round_defs_new, "r");
				$data_write_stats_round_defs = FRead ($fp_write_stats_round_defs, FileSize($file_write_stats_round_defs_new));
				FClose($fp_write_stats_round_defs); }
		
            	$fp_write_stats_round_defs = FOpen ($file_write_stats_round_defs_new, "w");
        		FWrite ($fp_write_stats_round_defs, $write_write_stats_round_defs.$data_write_stats_round_defs);
        		FClose ($fp_write_stats_round_defs);


            //TOTO JE TU NOVE!!!!
            //zaloha starych rounds stats    
            $file_write_stats_round_points_old = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/stats/points_round".$current_season.".txt";
			$file_write_stats_round_players = "tmp/points_round".$current_season."_".$yesterday.".txt";
			
			if (!file_exists($file_write_stats_round_players)) {
				if (File_exists($file_write_stats_round_points_old)) {
					$old = FOpen($file_write_stats_round_points_old, "r");
					$data_old = FRead ($old, filesize($file_write_stats_round_points_old));
					fclose($old);
				}
				$yes = FOpen ($file_write_stats_round_players, "w");
				FWrite ($yes, $data_old);
				Fclose ($yes);
			}
            
            $file_write_stats_round_goalies_old = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/stats/goalies_round".$current_season.".txt";
			$file_write_stats_round_goalies = "tmp/goalies_round".$current_season."_".$yesterday.".txt";
			
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
            
}
//ukladat priamo do countstats suboru... 
 
 
//prechod na: echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sum_stats.php\">";

?>



</div>
</body>
</html>