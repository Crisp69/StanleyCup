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
		<form action=\"playoff_schedule.php\" method=\"post\" name=\"form1\" onsubmit=\"return obfuscate()\">
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
function teamlist($team, $conf, $pool) {
	$team_dir = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/teams/teams.txt";
	echo "<table>";
	echo "<tr><td>&nbsp;<select name=\"$pool\"class=\"list\"><option value=\"\">&nbsp;!! select team !!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>";
	$f = fopen($team_dir,"r");
	while(!feof($f)) {
		$tmp = explode("|",fgets($f,2000));
		if (trim($tmp[0]) != "") {
			if ($team == trim($tmp[0])) {echo "<option SELECTED value=\"".trim($tmp[0]).";".trim($tmp[1]).";".trim($tmp[3])."\">&nbsp;".trim($tmp[1])."</option>";}
			else {
			  if($conf == "East") {if(($tmp[2]=="atlantic") || ($tmp[2]=="northeast") || ($tmp[2]=="southeast")){echo "<option value=\"".trim($tmp[0]).";".trim($tmp[1]).";".trim($tmp[3])."\">&nbsp;".trim($tmp[1])."</option>";}}
              if($conf == "West") {if(($tmp[2]=="central") || ($tmp[2]=="pacific") || ($tmp[2]=="northwest")){echo "<option value=\"".trim($tmp[0]).";".trim($tmp[1]).";".trim($tmp[3])."\">&nbsp;".trim($tmp[1])."</option>";}}
            } 
			 
		}
	}
	fclose($f);
	echo "</select></td></tr></table>";
}
?>

<SCRIPT LANGUAGE="JavaScript"><!--
function check(formular)
{
	
	if (formular.qf1_date.value=="")
    {
        alert("Tipe date of Game 1!");
        formular.qf1_date.focus();
        return false;
    }
    else if (formular.q_full_a1.value=="")
    {
        alert("Select team!");
        formular.q_full_a1.focus();
        return false;
    }
    else if (formular.q_full_b1.value=="")
    {
        alert("Select team!");
        formular.q_full_b1.focus();
        return false;
    }
    else if (formular.q_full_a5.value=="")
    {
        alert("Select team!");
        formular.q_full_a5.focus();
        return false;
    }
    else if (formular.q_full_b5.value=="")
    {
        alert("Select team!");
        formular.q_full_b5.focus();
        return false;
    }
	else 
        return true;
}


// -->
</SCRIPT>

<?php
$stadings_file = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/standings/standings".$current_season.".txt";
$playoff_file = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/schedule/playoff".$current_season.".txt";
    $count_results = 0;
    if(file_exists($playoff_file)) {
        $f = fopen($playoff_file, "r");
        while (!feof($f)) {
            $tmp = explode("|", fgets($f, 2000));
    		if (trim($tmp[0]) != "") {
                if(($tmp[0] == "Conference Finals") && $tmp[10] != "?") {
                    $count_results = $count_results + 1;
                }
            }
        }fclose($f);
    }		      
    if($count_results ==0) {
        echo "<br /><br /><b>Conference Finals</b><br /><br /><table align=\"center\"><tr><td colspan=\"2\">";
    	echo "<form name=\"playoff\" method=\"post\" onSubmit=\"return check(this)\">";
    	echo "<span class=\"mag_title_new\">date game 1 (Saturday):</span> [DD.MM.YYYY] <input type=\"text\" class=\"list\" name=\"qf1_date\" size=\"15\" value=\"";
    	if(isset($qf1_date)) {echo "$qf1_date";}
    	echo "\"></input></td></tr><tr><td>";
    	
    	if(file_exists($stadings_file)) {
        	$f = fopen($stadings_file,"r");
        	while(!feof($f)) {
        		$tmp = explode("|",fgets($f,2000));
        		if (trim($tmp[0]) != "") {
        			if(($tmp[4] == "East") && ($tmp[5] == "1")) {
        			teamlist($team, $conf=$tmp[4], $pool = "q_full_a1");
        			}
        		}
        	}
        	
        	echo "</td><td>";
        	$f = fopen($stadings_file,"r");
        	while(!feof($f)) {
        		$tmp = explode("|",fgets($f,2000));
        		if (trim($tmp[0]) != "") {
        			if(($tmp[4] == "East") && ($tmp[5] == "2")) {
        			teamlist($team, $conf=$tmp[4], $pool = "q_full_b1");
        			}
        		}
        	}
        
        	echo "</td></tr><tr><td>";
        
        	$f = fopen($stadings_file,"r");
        	while(!feof($f)) {
        		$tmp = explode("|",fgets($f,2000));
        		if (trim($tmp[0]) != "") {
        			if(($tmp[4] == "West") && ($tmp[5] == "1")) {
        			teamlist($team, $conf=$tmp[4], $pool = "q_full_a5");
        			}
        		}
        	}
        	
        	echo "</td><td>";
        	$f = fopen($stadings_file,"r");
        	while(!feof($f)) {
        		$tmp = explode("|",fgets($f,2000));
        		if (trim($tmp[0]) != "") {
        			if(($tmp[4] == "West") && ($tmp[5] == "2")) {
        			teamlist($team, $conf=$tmp[4], $pool = "q_full_b5");
        			}
        		}
        	}
        
         	echo "</td></tr></table>";
        	echo "<input type=\"hidden\" name=\"ok\" value=\"ok\">";
        	echo "<input type=\"submit\" class=\"date\" value=\"-- WRITE --\" />\n</form><p>";
        	if($ok == "ok") {
        	$tmp_qf1_date = explode(".",$qf1_date);
        	$tmp_date_1 = mktime(0, 0, 0, date($tmp_qf1_date[1])  , date($tmp_qf1_date[0])+1, date($tmp_qf1_date[2]));
        	$qf2_date = date("d.m.Y", $tmp_date_1);
        	$tmp_qf2_date = explode(".",$qf2_date);
        	
        	
        	$tmp_q_full_a1 = explode(";",$q_full_a1);
        	$tmp_q_full_b1 = explode(";",$q_full_b1);
        	$gm1 = "Conference Finals|".$tmp_q_full_a1[1]."|".$tmp_q_full_b1[1]."|".$tmp_q_full_a1[2]."|".$tmp_q_full_b1[2]."|".$tmp_qf1_date[0]."|".$tmp_qf1_date[1]."|".$tmp_qf1_date[2]."|".$tmp_q_full_a1[0]."|".$tmp_q_full_b1[0]."|?|?|1||1025\n";
        	$tmp_q_full_a5 = explode(";",$q_full_a5);
        	$tmp_q_full_b5 = explode(";",$q_full_b5);
        	$gm5 = "Conference Finals|".$tmp_q_full_a5[1]."|".$tmp_q_full_b5[1]."|".$tmp_q_full_a5[2]."|".$tmp_q_full_b5[2]."|".$tmp_qf1_date[0]."|".$tmp_qf1_date[1]."|".$tmp_qf1_date[2]."|".$tmp_q_full_a5[0]."|".$tmp_q_full_b5[0]."|?|?|2||1026\n";
        	$gm9 = "Conference Finals|".$tmp_q_full_b1[1]."|".$tmp_q_full_a1[1]."|".$tmp_q_full_b1[2]."|".$tmp_q_full_a1[2]."|".$tmp_qf2_date[0]."|".$tmp_qf2_date[1]."|".$tmp_qf2_date[2]."|".$tmp_q_full_b1[0]."|".$tmp_q_full_a1[0]."|?|?|1||1027\n";
        	$gm13 = "Conference Finals|".$tmp_q_full_b5[1]."|".$tmp_q_full_a5[1]."|".$tmp_q_full_b5[2]."|".$tmp_q_full_a5[2]."|".$tmp_qf2_date[0]."|".$tmp_qf2_date[1]."|".$tmp_qf2_date[2]."|".$tmp_q_full_b5[0]."|".$tmp_q_full_a5[0]."|?|?|2||1028\n";
        	
        	
        //	echo $gm1."<br />";
        //	echo $gm2."<br />";
        //	echo $gm3."<br />";
        //	echo $gm4."<br />";
        //	echo $gm5."<br />";
        //	echo $gm6."<br />";
        //	echo $gm7."<br />";
        //	echo $gm8."<br />";
        //	echo $gm9."<br />";
        //	echo $gm10."<br />";
        //	echo $gm11."<br />";
        //	echo $gm12."<br />";
        //	echo $gm13."<br />";
        //	echo $gm14."<br />";
        //	echo $gm15."<br />";
        //	echo $gm16."<br />";
        	
        		$write = $gm1.$gm5.$gm9.$gm13;
                
                $playoff_file_tmp = $_SERVER['DOCUMENT_ROOT']."/stanleycup/update/tmp/playoff".$current_season."cf.txt";
                if(file_exists($playoff_file_tmp)) {
                    if(filesize($playoff_file_tmp)!=0) {
                        $old_playoff_file = FOpen($playoff_file_tmp, "r");
                        $data_old_playoff = FRead ($old_playoff_file, filesize($playoff_file_tmp));
                        fclose($old_playoff_file);
                    }
                }
                else {
                    if(file_exists($playoff_file)) {
                        $old_playoff_file = FOpen($playoff_file, "r");
                        $data_old_playoff = FRead ($old_playoff_file, filesize($playoff_file));
                        fclose($old_playoff_file);}
                        $fp = FOpen ($playoff_file_tmp, "w");
        				FWrite ($fp, $data_old_playoff."\n");
        				FClose ($fp);                    
                }
                $write_playoff = StripSlashes($write."\n");
        				$fp = FOpen ($playoff_file, "w");
        				FWrite ($fp, $write_playoff.$data_old_playoff);
        				FClose ($fp); 
        				echo "<br /><br />done!<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1; URL=upload.php\">";
                $update_file = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/data/update".$current_season.".txt";
                    if (File_exists($update_file)) {
                		$old_update_file = FOpen($update_file, "r");
                		$data_old_update_file = FRead ($old_update_file, filesize($update_file));
                	fclose($old_update_file);}
                    $update_text = time()."|playoff schedule|schedule|\n";
                	$yes_update_file = FOpen ($update_file, "w");
                	FWrite ($yes_update_file, $update_text.$data_old_update_file);
                	Fclose ($yes_update_file);
        	}			
    	}
    }
    else {echo "game has been already played, you cannot edit the schedule anymore!!!";}

?>