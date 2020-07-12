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
		<form action=\"bo_evaluate_tickets.php\" method=\"post\" name=\"form1\" onsubmit=\"return obfuscate()\">
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
include ($_SERVER['DOCUMENT_ROOT']."/stanleycup/settings.php");
include("update_date.php");
//$tmp_yesterday  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
$date = date("Y-m-d", $tmp_yesterday);
//zmenit date na $yesterday
//$date = "2010-02-13";
//linky cez $server 
$upload_dir = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/betting/".$current_season."/"; 
$file_list = $upload_dir.$date.".txt";

$bets_number = file ($file_list);
$count = count($bets_number)-1;

echo "<center><form name=\"evaluateticket\" method=\"post\"><textarea readonly=\"readonly\" class=\"list\" name=\"evaluate_tickets\" cols=\"70\" rows=\"25\" >";

$id_ticket = 0;
if(file_exists($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt")) {$schedule = "playoff".$current_season;} else {$schedule = "schedule".$current_season;}

for ($i=$id_ticket; $i<=$count; $i++) {
    if(trim($bets_number[$i]) != "") {
        $file_bets = trim($bets_number[$i]);
        $tmp_nick = explode("_",$file_bets);
        if($tmp_nick[0] == $date) {
            $nick = trim(str_replace(".txt", "", $tmp_nick[1]));
            if(file_exists($upload_dir.$file_bets)) {
                $f = fopen($upload_dir.$file_bets, "r");
                while (!feof($f)) {
                    $tmp_bet = explode("|", fgets($f, 2000));
                    if(trim($tmp_bet[0]) != "") {
                        $f_schedule = fopen($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/".$schedule.".txt", "r");
                        while (!feof($f_schedule)) {
                            $tmp_schedule = explode("|", fgets($f_schedule, 2000));
                            if(trim($tmp_schedule[0]) != "") {
                                if($tmp_bet[1] ==  trim($tmp_schedule[14])) {
                                    if($tmp_schedule[10] != "?") {
                                    if($tmp_schedule[10]>$tmp_schedule[11]) {$result = "1"; $max_points = 1;}
                                    if($tmp_schedule[10]==$tmp_schedule[11]) {$result = "X"; $max_points = 2;}
                                    if($tmp_schedule[10]<$tmp_schedule[11]) {$result = "2"; $max_points = 1;}
                                    } else {$result = "?";}
                                    if(($tmp_bet[3] == $result) && ($result != "X")) {$points = 1;}
                                    elseif(($tmp_bet[3] == $result) && ($result == "X")) {$points = 2;}
                                    elseif(($tmp_bet[3] != $result)) {$points = -0.5;}
                                    
                                    $write[$nick] = $tmp_bet[0]."|".$tmp_bet[1]."|".$tmp_bet[2]."|".$tmp_bet[3]."|".$tmp_schedule[10]."|".$tmp_schedule[11]."|".$result."|".$tmp_schedule[13]."|".$points."|".$max_points."|";
                                    
                                }
                            }
                        }fclose($f_schedule);echo $nick."|".$write[$nick]."\n"; 
                    }
               }fclose($f);
            }
        }
    }                        
}   
echo "</textarea>";  
echo "<textarea readonly=\"readonly\" class=\"list\" name=\"write_sum\" cols=\"70\" rows=\"25\" >";
for ($i=$id_ticket; $i<=$count; $i++) {
    if(trim($bets_number[$i]) != "") {
        $file_bets = trim($bets_number[$i]);
        $tmp_nick = explode("_",$file_bets);
        $nick = trim(str_replace(".txt", "", $tmp_nick[1]));
        if($tmp_nick[0] == $date) {
            if(file_exists($upload_dir.$file_bets)) {
                $f = fopen($upload_dir.$file_bets, "r");
                $wins = 0;
                $ties = 0;
                $total = 0;
                $loss = 0;
                $max_pts = 0;
                while (!feof($f)) {
                    $tmp_bet = explode("|", fgets($f, 2000));
                    if(trim($tmp_bet[0]) != "") {
                        if(trim($nick != "all")) {
                            $f_schedule = fopen($_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/".$schedule.".txt", "r");
                            while (!feof($f_schedule)) {
                                $tmp_schedule = explode("|", fgets($f_schedule, 2000));
                                if(trim($tmp_schedule[0]) != "") {
                                    if($tmp_bet[1] ==  trim($tmp_schedule[14])) {
                                        if($tmp_schedule[10] != "?") {
                                        if($tmp_schedule[10]>$tmp_schedule[11]) {$result = "1"; $max_pts = $max_pts + 1;}
                                        if($tmp_schedule[10]==$tmp_schedule[11]) {$result = "X"; $max_pts =$max_pts + 2;}
                                        if($tmp_schedule[10]<$tmp_schedule[11]) {$result = "2"; $max_pts = $max_pts + 1;}
                                        } else {$result = "?";}
                                        if(($tmp_bet[3] == $result) && ($result != "X")) {$wins = $wins + 1;}
                                        elseif(($tmp_bet[3] == $result) && ($result == "X")) {$ties = $ties + 2;}
                                        elseif(($tmp_bet[3] != $result)) {$loss = $loss - 0.5;}
                                        $total = $total + 1;
                                        
                                    }
                                }
                            }fclose($f_schedule);
                             
                        }    
                    }
               }fclose($f);
               
            }echo "$nick|$wins|$total|$ties|$loss|$max_pts|\n";
        }
    }                        
}   

echo "</textarea>";

echo "\n<br /><input type=\"hidden\" name=\"ok1\" value=\"ok\">\n<br />write data --> <input type=\"submit\" class=\"date\" value=\"-- RUN --\" />\n</form></center><br />";
              
if($ok1 == "ok") {   
        
         $fp = FOpen ($upload_dir.$date."_all.txt", "w");
            FWrite ($fp, $evaluate_tickets);
        	FClose ($fp); 

       
			
			$fp = FOpen ($upload_dir.$date."_count.txt", "w");
			FWrite ($fp, $write_sum);
			FClose ($fp); 
            
            
            $update_file = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/data/update".$current_season.".txt";
            if (File_exists($update_file)) {
        		$old_update_file = FOpen($update_file, "r");
        		$data_old_update_file = FRead ($old_update_file, filesize($update_file));
        	fclose($old_update_file);}
            $update_text = time()."|betting office|bo|\n";
        	$yes_update_file = FOpen ($update_file, "w");
        	FWrite ($yes_update_file, $update_text.$data_old_update_file);
        	Fclose ($yes_update_file);
            
            
            echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1; URL=bo_count_sum.php\">";

}

?>