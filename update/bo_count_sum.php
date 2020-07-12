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
//linky cez $server 
echo "<center>...";
$file_result = "betting.txt";
$file_yesterday = $date."_count.txt";
$upload_dir = $_SERVER['DOCUMENT_ROOT']."/stanleycup/data/betting/".$current_season."/";
$file_result_tmp = "tmp/betting_".$date.".txt";

if(file_exists($upload_dir.$date."_all.txt")) {
if(!file_exists($file_result_tmp)) {
    if(file_exists($upload_dir.$file_result)) {
        $fpx = FOpen ($upload_dir.$file_result, "r");
				$datax = FRead ($fpx, FileSize($upload_dir.$file_result));
				FClose($fpx); } else {$datax = "\n\n\n";}
            
			$fpx = FOpen ($file_result_tmp, "w");
			FWrite ($fpx, $datax);
			FClose ($fpx);
}
if(!file_exists("tmp/rounds_".$date.".txt")) {
if ((File_Exists($upload_dir."rounds.txt")) && (Count(File($upload_dir."rounds.txt"))!=0)) {
        $fp2 = FOpen ($upload_dir."rounds.txt", "r");
			$data2 = FRead ($fp2, FileSize($upload_dir."rounds.txt"));
			FClose($fp2); }else {$data2 = "\n\n\n";}
                    
        $fp2 = FOpen ("tmp/rounds_".$date.".txt", "w");
            FWrite ($fp2, $data2);
        	FClose ($fp2);
}


if(file_exists($file_result_tmp)) {
    $f1 = fopen($file_result_tmp, "r");
    while(!feof($f1)) {
        $tmp_1 = explode("|", fgets($f1, 2000));
        if(trim($tmp_1[0] !="")) {
            if($tmp_1[0] != "all") {
                $nick1 = $tmp_1[0];
                $array_nick1[] = strtolower($nick1);
            }
        }
    }
}
if(file_exists($upload_dir.$file_yesterday)) {
    $f2 = fopen($upload_dir.$file_yesterday, "r");
    while(!feof($f2)) {
        $tmp_2 = explode("|", fgets($f2, 2000));
        if(trim($tmp_2[0] !="")) {
            if($tmp_2[0] != "all") {
                $nick2 = $tmp_2[0];
                $array_nick2[] = strtolower($nick2);
            }
        }
    }
}

if(isset($array_nick1) && isset($array_nick2)) {
    $array = array_unique(array_merge($array_nick1, $array_nick2));
    
}
elseif (!isset($array_nick1) && isset($array_nick2)) {
    $array = array_unique($array_nick2);
    
}
elseif (isset($array_nick1) && !isset($array_nick2)) {
    $array = array_unique($array_nick1);
    
}

foreach ($array as $key => $value) {
    $nick = strtolower($value);
    $wins[$nick] = 0;
    $total[$nick] = 0;
    $loss[$nick] = 0;
    $ties[$nick] = 0;
    $max_pts[$nick] = 0;
    if(file_exists($file_result_tmp)) {
        $f1 = fopen($file_result_tmp, "r");
        while(!feof($f1)) {
            $tmp_1 = explode("|", fgets($f1, 2000));
            if(trim($tmp_1[0] !="")) {
                if($nick == strtolower($tmp_1[0])) {
                    $wins[$nick] = $wins[$nick] + $tmp_1[1];
                    $total[$nick] = $total[$nick] + $tmp_1[2];
                    $loss[$nick] = $loss[$nick] + $tmp_1[4];
                    $ties[$nick] = $ties[$nick] + $tmp_1[3];
                    $max_pts[$nick] = $max_pts[$nick] + $tmp_1[5];
                    //echo $tmp_1[5];
                $nick_orig[$nick] = $tmp_1[0];   
                }
            }
        }fclose($f1);
    }
    if(file_exists($upload_dir.$file_yesterday)) {
        $f2 = fopen($upload_dir.$file_yesterday, "r");
        while(!feof($f2)) {
            $tmp_2 = explode("|", fgets($f2, 2000));
            if(trim($tmp_2[0] !="")) {
                if($nick == strtolower($tmp_2[0])) {
                    $wins[$nick] = $wins[$nick] + $tmp_2[1];
                    $total[$nick] = $total[$nick] + $tmp_2[2];
                    $loss[$nick] = $loss[$nick] + $tmp_2[4];
                    $ties[$nick] = $ties[$nick] + $tmp_2[3];
                    $max_pts[$nick] = $max_pts[$nick] + $tmp_2[5];
                $nick_orig[$nick] = $tmp_2[0];                    
                }
            }
        }fclose($f2);
    }
    $write = $nick_orig[$nick]."|".$wins[$nick]."|".$total[$nick]."|".$ties[$nick]."|".$loss[$nick]."|".$max_pts[$nick];
    //echo $write;
    $writes[] = $write;
}
//echo $upload_dir.$file_result;
    $write_results = implode("\n", $writes);
    //echo $write_results;
        $fp = FOpen ($upload_dir.$file_result, "w");
            FWrite ($fp, $write_results);
        	FClose ($fp);
            
            
        if ((File_Exists("tmp/rounds_".$date.".txt")) && (Count(File("tmp/rounds_".$date.".txt"))!=0)) {
				$fp2 = FOpen ("tmp/rounds_".$date.".txt", "r");
				$data2 = FRead ($fp2, FileSize("tmp/rounds_".$date.".txt"));
				FClose($fp2); }
                    
        $fp2 = FOpen ($upload_dir."rounds.txt", "w");
            FWrite ($fp2, $file_yesterday."|\n".$data2);
        	FClose ($fp2);


echo "<br/><br/><br/><a href=\"upload.php\">done!</a></center>";
//echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1; URL=upload.php\">";
}
else {echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1; URL=bo_evaluate_tickets.php\">";}
?>